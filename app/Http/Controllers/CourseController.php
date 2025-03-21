<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        return view('admin.course.create', compact('title', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
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
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
