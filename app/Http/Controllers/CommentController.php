<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    // Các phương thức hiện có
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
        ]);

        return back()->with('success', 'Câu hỏi đã được gửi thành công.');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'comment_id' => 'required|exists:comments,id',
        ]);

        $parentComment = Comment::findOrFail($request->comment_id);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'course_id' => $parentComment->course_id,
            'lesson_id' => $parentComment->lesson_id,
            'parent_id' => $request->comment_id,
        ]);

        return back()->with('success', 'Phản hồi đã được gửi thành công.');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        if (Auth::id() === $comment->user_id || Auth::user()->role === 'admin' || Auth::user()->role === 'teacher') {
            $comment->delete();
            return back()->with('success', 'Bình luận đã được xóa thành công.');
        }
        
        return back()->with('error', 'Bạn không có quyền xóa bình luận này.');
    }

    public function like(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        try {
            $comment = Comment::findOrFail($id);
            $userId = Auth::id();
            
            $liked = $comment->likes()->where('user_id', $userId)->exists();
            
            if ($liked) {
                // Bỏ thích
                $comment->likes()->detach($userId);
                $status = 'unliked';
            } else {
                // Thích
                $comment->likes()->attach($userId);
                $status = 'liked';
            }
            
            // Cập nhật cột likes
            $likesCount = $comment->likes()->count();
            $comment->update(['likes' => $likesCount]);
            
            return response()->json(['status' => $status, 'likes' => $likesCount]);
        } catch (\Exception $e) {
            \Log::error('Error in like function: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $likedComments = [];

        if (Auth::check()) {
            // Lấy danh sách ID bình luận/phản hồi mà người dùng đã thích
            $likedComments = Auth::user()->likedComments()->pluck('comment_id')->toArray();
        }

        return view('lessons.show', compact('lesson', 'likedComments'));
    }

    public function showReplyForm($commentId)
    {
        $parentComment = Comment::findOrFail($commentId);
        return view('comments.reply-form', compact('parentComment'));
    }

    // Các phương thức admin
    public function adminComments(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }
    
        $user = Auth::user();
        if ($user->role != 'admin' && $user->role != 'owner') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này');
        }
    
        $title = 'Quản lý bình luận';
        $query = Comment::with(['user', 'course', 'lesson', 'replies'])
            ->orderBy('created_at', 'desc');
    
        // Tìm kiếm theo nội dung hoặc tên người dùng
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('content', 'like', '%' . $search . '%');
                  });
            });
        }
    
        // Lọc theo khóa học
        if ($courseId = $request->input('course_id')) {
            $query->where('course_id', $courseId);
        }
    
        $comments = $query->paginate(10);
    
        // Giữ lại các tham số tìm kiếm trong phân trang
        $comments->appends($request->only(['search', 'course_id']));
    
        return view('admin.comment.index', compact('comments', 'title'));
    }

    public function adminDelete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return back()->with('success', 'Bình luận đã xóa thành công');
    }

    public function adminBulkDelete(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->comment_ids)->delete();

        return back()->with('success', 'Bình luận đã xóa thành công');
    }
   
}