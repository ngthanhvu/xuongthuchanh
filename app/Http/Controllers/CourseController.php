<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Khoá học';
        $course = Course::all();
        return view('admin.course.index', compact('course', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm khoá học';
        $categories = DB::table('categories')->get();
        $course = Course::all();
        return view('admin.course.create', compact('title', 'course', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|image|max:2048',
            'price' => 'required',
            'discount' => 'required',
            'category_id' => 'required'
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'price' => $request->price,
            'discount' => $request->discount,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id


        ]);
        return redirect()->route('admin.course.index')->with('success', 'Them thanh cong');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Chinhr sửa khóa học';
        $categories = DB::table('categories')->get();
        $course = Course::findOrFail($id);
        return view('admin.course.edit', compact('title', 'course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'price' => 'required',
            'discount' => 'required',
            'category_id' => 'required',
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
        $course->discount = $request->discount;
        $course->category_id = $request->category_id;
        $course->save();

        return redirect()->route('admin.course.index')->with('success', 'Cập nhật khóa học thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.course.index')->with('success', 'Xóa khóa học thông');
    }
}
