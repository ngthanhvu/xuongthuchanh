<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $title = 'Quản lí khóa học';
        $courses = Course::with('user', 'category')->get();
        return view('admin.course.index', compact('courses', 'title'));
    }

    public function create()
    {
        $title = 'Tạo khóa học';
        $users = User::all();
        $categories = Category::all();
        return view('admin.course.create', compact('users', 'categories', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'thumbnail' => $thumbnailPath,
            'price' => $request->price,
            'categories_id' => $request->categories_id,
            'is_free' => $request->price == 0 ? true : false,
        ]);

        return redirect()->route('admin.course.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('user', 'category', 'sections', 'posts', 'reviews');
        return view('admin.course.show', compact('course'));
    }

    public function edit($id)
    {
        $title = 'Sửa khóa học';
        $users = User::all();
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.course.edit', compact('course', 'users', 'categories', 'title'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::delete('public/' . $course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
            $course->thumbnail = $thumbnailPath;
        }

        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->categories_id = $request->categories_id;
        $course->is_free = $request->price == 0 ? true : false;
        $course->save();

        return redirect()->route('admin.course.index')->with('success', 'Khóa học đã được cập nhật thành công.');
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.course.index')->with('success', 'Course deleted successfully.');
    }
}
