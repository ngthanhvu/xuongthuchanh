<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

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
            'answer_text' => 'required',
            'is_correct' => 'required|boolean',
        ]);

        Answer::create($request->all());
        return redirect()->route('admin.answers.index')->with('success', 'Answer created successfully.');
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
}
