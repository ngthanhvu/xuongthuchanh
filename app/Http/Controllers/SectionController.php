<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $title = 'Quản lí section';
        $courses = Course::all();
        $sections = DB::table('sections')->paginate(5);
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
        ]);

        Section::create([
            'course_id' => $request->course_id,
            'title' => $request->title
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
        $courses = DB::table('courses')->get();
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
}
