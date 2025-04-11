<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user', 'course')->get();
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        $users = User::all();
        $courses = Course::all();
        return view('reviews.create', compact('users', 'courses'));
    }

    // ReviewController.php
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|numeric|min:1|max:5',
            'content' => 'nullable|string|max:1000', 
        ]);

        $existingReview = Review::where('user_id', auth()->id())
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá khóa học này rồi.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'course_id' => $request->course_id,
            'rating' => $request->rating,
            'content' => $request->content, 
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được ghi nhận. Cảm ơn sự đóng góp của bạn!');
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply' => $request->admin_reply
        ]);

        return back()->with('success', 'Phản hồi của bạn đã được gửi.');
    }

    public function show(Review $review)
    {
        $review->load('user', 'course');
        return view('reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        $users = User::all();
        $courses = Course::all();
        return view('reviews.edit', compact('review', 'users', 'courses'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|numeric|min:1|max:5',
            'content' => 'nullable|string|max:1000',
        ]);
        $review->update($request->all());
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        if (auth()->user()->role ==! 'admin' && auth()->user()->id !== $review->user_id) {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $review->delete();
        return back()->with('success', 'Đánh giá đã được xóa thành công.');
    }
}
