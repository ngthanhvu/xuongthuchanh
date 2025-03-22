<?php

namespace App\Http\Controllers;

use App\Models\UserQuizResult;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Http\Request;

class UserQuizResultController extends Controller
{
    public function index()
    {
        $userQuizResults = UserQuizResult::with('user', 'quiz')->get();
        return view('user_quiz_results.index', compact('userQuizResults'));
    }

    public function create()
    {
        $users = User::all();
        $quizzes = Quiz::all();
        return view('user_quiz_results.create', compact('users', 'quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'required|numeric|min:0|max:100',
            'submitted_at' => 'required|date',
        ]);

        UserQuizResult::create($request->all());
        return redirect()->route('user-quiz-results.index')->with('success', 'User Quiz Result created successfully.');
    }

    public function show(UserQuizResult $userQuizResult)
    {
        $userQuizResult->load('user', 'quiz');
        return view('user_quiz_results.show', compact('userQuizResult'));
    }

    public function edit(UserQuizResult $userQuizResult)
    {
        $users = User::all();
        $quizzes = Quiz::all();
        return view('user_quiz_results.edit', compact('userQuizResult', 'users', 'quizzes'));
    }

    public function update(Request $request, UserQuizResult $userQuizResult)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'required|numeric|min:0|max:100',
            'submitted_at' => 'required|date',
        ]);

        $userQuizResult->update($request->all());
        return redirect()->route('user-quiz-results.index')->with('success', 'User Quiz Result updated successfully.');
    }

    public function destroy(UserQuizResult $userQuizResult)
    {
        $userQuizResult->delete();
        return redirect()->route('user-quiz-results.index')->with('success', 'User Quiz Result deleted successfully.');
    }
}
