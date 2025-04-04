<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    // Admin functions
    public function index()
    {
        $title = 'Quản lí bài học';
        $section = Section::all();
        $lessons = Lesson::with('section')->paginate(5);
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
        ], [
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
            'file_url' => $request->file_url,
            'user_id' => Auth::id(), // Thêm user_id
        ]);
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function show(Lesson $lesson)
    {
        $lesson->load('section', 'quizzes');
        return view('admin.lessons.show', compact('lesson')); // Sửa 'lessons' thành 'lesson'
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
            'user_id' => Auth::id(), // Cập nhật user_id
        ]);
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function delete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }

    // Teacher functions
    public function indexTeacher()
    {
        $title = 'Quản lí bài học';
        $sections = Section::whereHas('course', function ($q) {
            $q->where('user_id', Auth::id());
        })->get();
        $lessons = Lesson::ofTeacher()->with('section')->paginate(5);
        return view('teacher.lessons.index', compact('lessons', 'title', 'sections'));
    }

    public function createTeacher()
    {
        $title = 'Tạo bài học';
        $sections = Section::whereHas('course', function ($q) {
            $q->where('user_id', Auth::id());
        })->get();
        return view('teacher.lessons.create', compact('sections', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required',
            'type' => 'required',
            'content' => 'nullable',
            'file_url' => 'nullable|url',
        ], [
            'section_id.required' => 'Vui lòng chọn section',
            'title.required' => 'Vui lòng nhập tên bài học',
            'type.required' => 'Vui lòng chọn loại bài học',
        ]);

        // Kiểm tra section thuộc khóa học của teacher
        $section = Section::where('id', $request->section_id)
            ->whereHas('course', function ($q) {
                $q->where('user_id', Auth::id());
            })->first();
        if (!$section) {
            return back()->withErrors(['section_id' => 'Bạn không có quyền thêm bài học vào section này.']);
        }

        Lesson::create([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_url' => $request->file_url,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('teacher.lessons.index')->with('success', 'Bài học đã được tạo thành công.');
    }

    public function editTeacher($id)
    {
        $title = 'Sửa bài học';
        $lesson = Lesson::ofTeacher()->findOrFail($id);
        $sections = Section::whereHas('course', function ($q) {
            $q->where('user_id', Auth::id());
        })->get();
        return view('teacher.lessons.edit', compact('lesson', 'sections', 'title'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $lesson = Lesson::ofTeacher()->findOrFail($id);
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required',
            'type' => 'required',
            'content' => 'nullable',
            'file_url' => 'nullable|url',
        ]);

        // Kiểm tra section thuộc khóa học của teacher
        $section = Section::where('id', $request->section_id)
            ->whereHas('course', function ($q) {
                $q->where('user_id', Auth::id());
            })->first();
        if (!$section) {
            return back()->withErrors(['section_id' => 'Bạn không có quyền cập nhật bài học vào section này.']);
        }

        $lesson->update([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_url' => $request->file_url,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('teacher.lessons.index')->with('success', 'Bài học đã được cập nhật thành công.');
    }

    public function deleteTeacher($id)
    {
        $lesson = Lesson::ofTeacher()->findOrFail($id);
        $lesson->delete();
        return redirect()->route('teacher.lessons.index')->with('success', 'Bài học đã được xóa thành công.');
    }
}