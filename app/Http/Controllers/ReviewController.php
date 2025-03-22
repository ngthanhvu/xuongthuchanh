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

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable',
        ]);

        Review::create($request->all());
        return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
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
            'comment' => 'nullable',
        ]);

        $review->update($request->all());
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
