<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // Admin functions
    public function index()
    {
        $title = 'Quản lí section';
        $courses = Course::all();
        $sections = Section::with('course')->paginate(5);
        return view('admin.sections.index', compact('sections', 'title', 'courses'));
    }

    public function create()
    {
        $title = 'Thêm section';
        $courses = Course::all();
        return view('admin.sections.create', compact('courses', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
        ], [
            'course_id.required' => 'Vui lòng chọn khóa học',
            'title.required' => 'Vui lòng nhập tiêu đề'
        ]);

        Section::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'user_id' => Auth::id(),

        ]);
        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully.');
    }

    public function show(Section $section)
    {
        $section->load('course', 'lessons');
        return view('admin.sections.show', compact('section'));
    }

    public function edit($id)
    {
        $title = 'Sửa section';
        $section = Section::findOrFail($id);
        $courses = Course::all();
        return view('admin.sections.edit', compact('section', 'courses', 'title'));
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
        ]);

        $section->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
        ]);
        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully.');
    }

    public function delete($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully.');
    }

    // Teacher functions
    public function indexTeacher()
    {
        $title = 'Quản lí section';
        // Chỉ lấy section thuộc khóa học của teacher hiện tại
        $sections = Section::ofTeacher()->with('course')->paginate(5);
        $courses = Course::where('user_id', Auth::id())->get();
        return view('teacher.sections.index', compact('sections', 'title', 'courses'));
    }

    public function createTeacher()
    {
        $title = 'Thêm section';
        // Chỉ lấy khóa học của teacher hiện tại
        $courses = Course::where('user_id', Auth::id())->get();
        return view('teacher.sections.create', compact('courses', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
        ], [
            'course_id.required' => 'Vui lòng chọn khóa học',
            'title.required' => 'Vui lòng nhập tiêu đề'
        ]);

        // Kiểm tra xem course_id có thuộc teacher hiện tại không
        $course = Course::where('id', $request->course_id)->where('user_id', Auth::id())->first();
        if (!$course) {
            return back()->withErrors(['course_id' => 'Bạn không có quyền thêm section vào khóa học này.']);
        }

        Section::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'user_id' => Auth::id(), // Thêm user_id của teacher hiện tại
        ]);
        return redirect()->route('teacher.sections.index')->with('success', 'Section created successfully.');
    }

    public function editTeacher($id)
    {
        $title = 'Sửa section';
        // Chỉ lấy section của teacher hiện tại
        $section = Section::ofTeacher()->findOrFail($id);
        $courses = Course::where('user_id', Auth::id())->get();
        return view('teacher.sections.edit', compact('section', 'courses', 'title'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $section = Section::ofTeacher()->findOrFail($id);
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
        ]);

        // Kiểm tra xem course_id có thuộc teacher hiện tại không
        $course = Course::where('id', $request->course_id)->where('user_id', Auth::id())->first();
        if (!$course) {
            return back()->withErrors(['course_id' => 'Bạn không có quyền cập nhật section vào khóa học này.']);
        }

        $section->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
        ]);
        return redirect()->route('teacher.sections.index')->with('success', 'Section updated successfully.');
    }

    public function deleteTeacher($id)
    {
        $section = Section::ofTeacher()->findOrFail($id);
        $section->delete();
        return redirect()->route('teacher.sections.index')->with('success', 'Section deleted successfully.');
    }
}
