<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('user', 'category')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('courses.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'thumbnail' => 'nullable',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('user', 'category', 'sections', 'posts', 'reviews');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $users = User::all();
        $categories = Category::all();
        return view('courses.edit', compact('course', 'users', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'thumbnail' => 'nullable',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
