<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('quiz')->get();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quiz::all();
        return view('questions.create', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required',
        ]);

        Question::create($request->all());
        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    public function show(Question $question)
    {
        $question->load('quiz', 'answers');
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required',
        ]);

        $question->update($request->all());
        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
}
