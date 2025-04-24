<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $title = 'Danh sách Câu Hỏi';
        $questions = Question::with('quiz')->get();
        return view('admin.questions.index', compact('questions', 'title'));
    }

    public function create()
    {
        $title = 'Tạo Câu Hỏi';
        $quizzes = Quiz::all();
        return view('admin.questions.create', compact('quizzes', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required',
        ]);

        Question::create([
            'quiz_id' => $request->quiz_id,
            'question_text' => $request->question_text,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function show(Question $question)
    {
        $question->load('quiz', 'answers');
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('admin.questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required',
        ]);

        $question->update($request->all());
        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }

    public function indexTeacher()
    {
        $title = 'Quản lý câu hỏi';
        $questions = Question::where('user_id', Auth::id())->with('quiz')->get();
        return view('teacher.questions.index', compact('questions', 'title'));
    }

    public function createTeacher()
    {
        $title = 'Tạo câu hỏi';
        // Chỉ quiz của giáo viên mới thấy
        $quizzes = Quiz::where('user_id', Auth::id())->get();
        return view('teacher.questions.create', compact('quizzes', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required',
        ]);

        $quiz = Quiz::where('id', $request->quiz_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$quiz) {
            return back()->withErrors(['quiz_id' => 'Bạn không có quyền tạo câu hỏi cho quiz này.']);
        }

        Question::create([
            'quiz_id' => $request->quiz_id,
            'question_text' => $request->question_text,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('teacher.questions.index')->with('success', 'Câu hỏi đã được tạo thành công.');
    }

    public function showTeacher(Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem câu hỏi này.');
        }

        $question->load('quiz', 'answers');
        return view('teacher.questions.show', compact('question'));
    }

    public function editTeacher(Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa câu hỏi này.');
        }

        $title = 'Chỉnh sửa câu hỏi';
        $quizzes = Quiz::where('user_id', Auth::id())->get();
        return view('teacher.questions.edit', compact('question', 'quizzes', 'title'));
    }

    public function updateTeacher(Request $request, Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền cập nhật câu hỏi này.');
        }

        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required',
        ]);

        $quiz = Quiz::where('id', $request->quiz_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$quiz) {
            return back()->withErrors(['quiz_id' => 'Bạn không có quyền gán quiz này.']);
        }

        $question->update([
            'quiz_id' => $request->quiz_id,
            'question_text' => $request->question_text,
        ]);

        return redirect()->route('teacher.questions.index')->with('success', 'Câu hỏi đã được cập nhật.');
    }

    public function destroyTeacher(Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa câu hỏi này.');
        }

        $question->delete();
        return redirect()->route('teacher.questions.index')->with('success', 'Câu hỏi đã được xoá.');
    }
}
