<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        // Kiểm tra xem người dùng đã đăng ký khóa học chưa
        $isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->exists();

        if (!$isEnrolled) {
            return back()->with('error', 'Bạn cần đăng ký khóa học để có thể bình luận.');
        }

        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Đã đăng bình luận thành công.');
    }

    public function update(Request $request, Comment $comment)
    {
        // Kiểm tra quyền sửa bình luận
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền sửa bình luận này.');
        }

        $request->validate([
            'content' => 'required|string',
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return back()->with('success', 'Đã cập nhật bình luận thành công.');
    }

    public function destroy(Comment $comment)
    {
        // Kiểm tra quyền xóa bình luận (chỉ người viết hoặc admin có thể xóa)
        if ($comment->user_id !== Auth::id() && !Auth::user()->hasRole(['admin', 'owner'])) {
            return back()->with('error', 'Bạn không có quyền xóa bình luận này.');
        }

        $comment->delete();
        return back()->with('success', 'Đã xóa bình luận thành công.');
    }
}