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
    // Admin functions
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

        $thumbnailPath = $request->file('thumbnail') ? $request->file('thumbnail')->store('courses', 'public') : null;

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
        if ($course->thumbnail) {
            Storage::delete('public/' . $course->thumbnail);
        }
        $course->delete();
        return redirect()->route('admin.course.index')->with('success', 'Course deleted successfully.');
    }

    // Teacher functions
    public function indexTeacher()
    {
        $title = 'Quản lí khóa học';
        $query = Course::where('user_id', Auth::id())->with('user', 'category');
        
        if (request()->has('search')) {
            $searchTerm = request('search');
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'a-z';
                $query->orderBy('title', 'asc');
                break;
            case 'z-a';
                $query->orderBy('title', 'desc');
                break;
            case 'price-asc';
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc';
                $query->orderBy('price', 'desc');
                break;
            case 'newest';
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest';
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $courses = $query->get();
        return view('teacher.course.index', compact('courses', 'title', 'sort'));
    }

    public function createTeacher()
    {
        $title = 'Tạo khóa học';
        $categories = Category::all();
        return view('teacher.course.create', compact('categories', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        $thumbnailPath = $request->file('thumbnail') ? $request->file('thumbnail')->store('courses', 'public') : null;

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'thumbnail' => $thumbnailPath,
            'price' => $request->price,
            'categories_id' => $request->categories_id,
            'is_free' => $request->price == 0 ? true : false,
        ]);

        return redirect()->route('teacher.course.index')->with('success', 'Khóa học đã được tạo thành công.');
    }

    public function editTeacher($id)
    {
        $title = 'Sửa khóa học';
        $course = Course::where('user_id', Auth::id())->findOrFail($id); // Chỉ cho phép chỉnh sửa khóa học của teacher
        $categories = Category::all();
        return view('teacher.course.edit', compact('course', 'categories', 'title'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $course = Course::where('user_id', Auth::id())->findOrFail($id); // Chỉ cho phép cập nhật khóa học của teacher
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

        return redirect()->route('teacher.course.index')->with('success', 'Khóa học đã được cập nhật thành công.');
    }

    public function deleteTeacher($id)
    {
        $course = Course::where('user_id', Auth::id())->findOrFail($id); // Chỉ cho phép xóa khóa học của teacher
        if ($course->thumbnail) {
            Storage::delete('public/' . $course->thumbnail);
        }
        $course->delete();
        return redirect()->route('teacher.course.index')->with('success', 'Khóa học đã được xóa thành công.');
    }
}