<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use App\Models\UserQuizResult;

class QuizController extends Controller
{
    // Admin functions
    public function index()
    {
        $title = 'Quizzes';
        $quizzes = Quiz::with('lesson')->get();
        return view('admin.quizzes.index', compact('quizzes', 'title'));
    }

    public function create()
    {
        $title = 'Tạo quizz';
        $lessons = Lesson::all();
        return view('admin.quizzes.create', compact('lessons', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required',
            'description' => 'nullable',
        ]);

        Quiz::create(array_merge($request->all(), ['user_id' => Auth::id()]));
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function show(Quiz $quiz)
    {
        $userId = Auth::check() ? Auth::id() : null;

        $lesson = $quiz->lesson;
        $section = $lesson ? $lesson->section : null;
        $course = $section ? $section->course : null;

        $isEnrolled = false;
        if ($userId && $course) {
            $isEnrolled = Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->exists();
        }
        if ($isEnrolled) {
            $quiz->load([
                'questions.answers' => function ($query) {
                    $query->orderBy('is_correct', 'desc');
                }
            ]);
        }
        return view('showquizz', compact('quiz', 'isEnrolled', 'course'));
    }

    public function edit(Quiz $quiz)
    {
        $title = 'Sửa quizz';
        $lessons = Lesson::all();
        return view('admin.quizzes.edit', compact('quiz', 'lessons', 'title'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $quiz->update($request->all());
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    // Teacher functions
    public function indexTeacher()
    {
        $title = 'Quản lí bài kiểm tra';
        $quizzes = Quiz::ofTeacher()->with('lesson')->get();
        return view('teacher.quizzes.index', compact('quizzes', 'title'));
    }

    public function createTeacher()
    {
        $title = 'Tạo bài kiểm tra';
        $lessons = Lesson::where('user_id', Auth::id())->get(); // Chỉ lấy lesson của teacher
        return view('teacher.quizzes.create', compact('lessons', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $lesson = Lesson::where('id', $request->lesson_id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$lesson) {
            return back()->withErrors(['lesson_id' => 'Bạn không có quyền tạo quiz cho lesson này.']);
        }

        Quiz::create([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('teacher.quizzes.index')->with('success', 'Bài kiểm tra đã được tạo thành công.');
    }

    public function showTeacher(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem bài kiểm tra này.');
        }

        $quiz->load('lesson', 'questions.answers');
        return view('teacher.quizzes.show', compact('quiz'));
    }

    public function editTeacher(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài kiểm tra này.');
        }

        $title = 'Sửa bài kiểm tra';
        $lessons = Lesson::where('user_id', Auth::id())->get();
        return view('teacher.quizzes.edit', compact('quiz', 'lessons', 'title'));
    }

    public function updateTeacher(Request $request, Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền cập nhật bài kiểm tra này.');
        }

        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $lesson = Lesson::where('id', $request->lesson_id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$lesson) {
            return back()->withErrors(['lesson_id' => 'Bạn không có quyền cập nhật quiz cho lesson này.']);
        }

        $quiz->update([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('teacher.quizzes.index')->with('success', 'Bài kiểm tra đã được cập nhật thành công.');
    }

    public function destroyTeacher(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa bài kiểm tra này.');
        }

        $quiz->delete();
        return redirect()->route('teacher.quizzes.index')->with('success', 'Bài kiểm tra đã được xóa thành công.');
    }
}