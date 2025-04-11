<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
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

    // Trong CommentController.php
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Kiểm tra quyền
        if (Auth::id() !== $comment->user_id && !in_array(Auth::user()->role, ['admin', 'teacher'])) {
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
        }

        $comment->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Bình luận đã được cập nhật thành công.');
    }

    public function destroy(Comment $comment)
    {
        // Kiểm tra quyền
        if (Auth::id() !== $comment->user_id && !in_array(Auth::user()->role, ['admin', 'teacher'])) {
            return back()->with('error', 'Bạn không có quyền xóa bình luận này.');
        }

        $comment->delete();

        return back()->with('success', 'Bình luận đã được xóa thành công.');
    }

    public function like(Request $request, $id)
    {
        try {
            // Log thông tin để debug
            \Log::info('Like request received for comment: ' . $id);
            
            $comment = Comment::findOrFail($id);
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
            
            // Kiểm tra xem người dùng đã thích bình luận này chưa
            $liked = DB::table('comment_likes')
                        ->where('user_id', $userId)
                        ->where('comment_id', $id)
                        ->exists();
            
            \Log::info('User ' . $userId . ' has liked comment ' . $id . ': ' . ($liked ? 'yes' : 'no'));
            
            if ($liked) {
                // Nếu đã thích rồi, bỏ thích
                DB::table('comment_likes')
                    ->where('user_id', $userId)
                    ->where('comment_id', $id)
                    ->delete();
                
                $comment->decrement('likes');
                return response()->json(['status' => 'unliked', 'likes' => $comment->likes]);
            } else {
                // Nếu chưa thích, thêm like mới
                DB::table('comment_likes')->insert([
                    'user_id' => $userId,
                    'comment_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                $comment->increment('likes');
                return response()->json(['status' => 'liked', 'likes' => $comment->likes]);
            }
        } catch (\Exception $e) {
            \Log::error('Error in like function: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Phương thức reply đã có, nhưng có thể cần điều chỉnh để hiển thị form reply
    public function showReplyForm($commentId)
    {
        $parentComment = Comment::findOrFail($commentId);
        return view('comments.reply-form', compact('parentComment'));
    }
}