<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $title = 'Quản lí bài học';
        $section = Section::all();
        $lessons = DB::table('lessons')->paginate(5);
        return view('admin.lessons.index', compact('lessons', 'title', 'section'));
    }

    public function create()
    {
        $title = 'Tạo bài học';
        $sections = Section::all();
        return view('admin.lessons.create', compact('sections', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required',
            'type' => 'required',
            'content' => 'nullable',
            'file_url' => 'nullable|url',
        ],[
            'section_id.required' => 'Vui lòng chọn khoa học',
            'title.required' => 'Vui lòng nhập tên bài học',
            'type.required' => 'Vui lòng chọn loại bài học',
            'content.required' => 'Vui lòng nhập nội dung bài học',
            'file_url.required' => 'Vui lòng nhập link video',
        ]);

        Lesson::create([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_url' => $request->file_url
        ]);
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function show(Lesson $lesson)
    {
        $lesson->load('section', 'quizzes');
        return view('lessons', compact('lessons'));
    }

    public function edit($id)
    {
        $title = 'Sửa bài học';
        $lesson = Lesson::findOrFail($id);
        $sections = Section::all();
        return view('admin.lessons.edit', compact('lesson', 'sections', 'title'));
    }

    public function update(Request $request, $id)
        {
        $lesson = Lesson::findOrFail($id);
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required',
            'type' => 'required',
            'content' => 'nullable',
            'file_url' => 'nullable|url',
        ]);

        $lesson->update([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_url' => $request->file_url,
        ]);
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function delete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
