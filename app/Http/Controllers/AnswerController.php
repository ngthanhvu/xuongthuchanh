<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index()
    {
        $title = 'Danh sách Câu Hỏi';
        $answers = Answer::with('question')->get();
        return view('admin.answers.index', compact('answers', 'title'));
    }

    public function create()
    {
        $title = 'Tạo Câu Hỏi';
        $questions = Question::all();
        return view('admin.answers.create', compact('questions', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string', // Ensure 'answer_text' is provided and a string
            'is_correct' => 'required|boolean',
        ]);

        Answer::create([
            'question_id' => $request->input('question_id'),
            'answer_text' => $request->input('answer_text'),
            'is_correct' => $request->input('is_correct'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.answers.index')->with('success', 'Answer added successfully!');
    }


    public function show(Answer $answer)
    {
        $answer->load('question');
        return view('admin.answers.show', compact('answer'));
    }

    public function edit(Answer $answer)
    {
        $title = 'Sửa Câu Hỏi';
        $questions = Question::all();
        return view('admin.answers.edit', compact('answer', 'questions', 'title'));
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required',
            'is_correct' => 'required|boolean',
        ]);

        $answer->update($request->all());
        return redirect()->route('admin.answers.index')->with('success', 'Answer updated successfully.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
        return redirect()->route('admin.answers.index')->with('success', 'Answer deleted successfully.');
    }

    //teacher
    public function indexTeacher()
    {
        $title = 'Danh sách Câu Trả Lời (Giáo viên)';
        $answers = Answer::ofTeacher()->with('question')->get();
        return view('teacher.answers.index', compact('answers', 'title'));
    }

    public function createTeacher()
    {
        $title = 'Tạo Câu Trả Lời';
        $questions = Question::ofTeacher()->get();
        return view('teacher.answers.create', compact('questions', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required',
            'is_correct' => 'required|boolean',
        ]);

        $question = Question::where('id', $request->question_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$question) {
            return back()->withErrors(['question_id' => 'Bạn không có quyền thêm câu trả lời cho câu hỏi này.']);
        }

        Answer::create([
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text,
            'is_correct' => $request->is_correct,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('teacher.answers.index')->with('success', 'Câu trả lời đã được tạo thành công.');
    }

    public function showTeacher(Answer $answer)
    {
        if ($answer->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem câu trả lời này.');
        }

        $answer->load('question');
        return view('teacher.answers.show', compact('answer'));
    }

    public function editTeacher(Answer $answer)
    {
        if ($answer->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa câu trả lời này.');
        }

        $title = 'Sửa Câu Trả Lời';
        $questions = Question::ofTeacher()->get();
        return view('teacher.answers.edit', compact('answer', 'questions', 'title'));
    }

    public function updateTeacher(Request $request, Answer $answer)
    {
        if ($answer->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền cập nhật câu trả lời này.');
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required',
            'is_correct' => 'required|boolean',
        ]);

        $question = Question::where('id', $request->question_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$question) {
            return back()->withErrors(['question_id' => 'Bạn không có quyền sửa câu trả lời cho câu hỏi này.']);
        }

        $answer->update([
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text,
            'is_correct' => $request->is_correct,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('teacher.answers.index')->with('success', 'Câu trả lời đã được cập nhật thành công.');
    }

    public function destroyTeacher(Answer $answer)
    {
        if ($answer->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa câu trả lời này.');
        }

        $answer->delete();
        return redirect()->route('teacher.answers.index')->with('success', 'Câu trả lời đã được xóa thành công.');
    }
}
