<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\UserQuizResult;

class QuizController extends Controller
{
    public function index()
    {
        $title = 'Quizzes';
        $quizzes = Quiz::with('lesson')->get();
        return view('admin.quizzes.index', compact('quizzes', 'title'));
    }

    public function create()
    {
        $lessons = Lesson::all();
        return view('admin.quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required',
            'description' => 'nullable',
        ]);

        Quiz::create($request->all());
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load([
            'questions.answers' => function ($query) {
                $query->orderBy('is_correct', 'desc');
            }
        ]);

        return view('showquizz', compact('quiz')); // Đúng đường dẫn tới file blade
    }


    public function submitQuiz(Request $request, Quiz $quiz)
    {
        if (!$request->has('answers')) {
            return redirect()->route('showquizz', ['quiz' => $quiz->id])
                ->with('error', 'Bạn chưa chọn đáp án nào!');
        }

        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            if (isset($request->answers[$question->id])) {
                $selectedAnswerId = $request->answers[$question->id];

                $correctAnswer = $question->answers->where('is_correct', true)->first();

                if ($correctAnswer && $correctAnswer->id == $selectedAnswerId) {
                    $correctAnswers++;
                }
            }
        }
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('showquizz', ['quiz' => $quiz->id])
                ->with('error', 'Bạn cần đăng nhập để làm bài quiz!');
        }

        UserQuizResult::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'submitted_at' => now(),
        ]);

        return redirect()->route('showquizz', ['quiz' => $quiz->id])
            ->with('success', "Bạn đã trả lời $correctAnswers/$totalQuestions câu! Điểm: $score.");
    }

    // public function submitQuiz(Request $request, Quiz $quiz)
    // {
    //     if (!$request->has('answers')) {
    //         return redirect()->route('admin.quizzes.show', $quiz->id)
    //             ->with('error', 'Bạn chưa chọn đáp án nào!');
    //     }

    //     $correctAnswers = 0;
    //     $totalQuestions = $quiz->questions->count();

    //     foreach ($quiz->questions as $question) {
    //         if (isset($request->answers[$question->id])) {
    //             $selectedAnswerId = $request->answers[$question->id];

    //             $correctAnswer = $question->answers->where('is_correct', true)->first();

    //             if ($correctAnswer && $correctAnswer->id == $selectedAnswerId) {
    //                 $correctAnswers++; 
    //             }
    //         }
    //     }

    //     return redirect()->route('showquizz', ['quiz' => $quiz->id])
    //     ->with('success', "Bạn đã trả lời đúng $correctAnswers/$totalQuestions câu!");
    // }




    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::all();
        return view('admin.quizzes.edit', compact('quiz', 'lessons'));
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
}
