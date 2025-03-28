<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\UserQuizResult;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $title = 'Trang chủ';
        $courses = Course::all();
        $enrollments = Auth::check() ? Enrollment::where('user_id', Auth::id())->get() : null;
        $userId = Auth::check() ? Auth::id() : null;

        $enrollmentStatus = [];
        $links = [];

        if ($userId) {
            foreach ($courses as $course) {
                $isEnrolled = Enrollment::where('user_id', $userId)->where('course_id', $course->id)->exists();
                $enrollmentStatus[$course->id] = $isEnrolled;

                if ($isEnrolled) {
                    $firstSection = Section::where('course_id', $course->id)->first();
                    if ($firstSection) {
                        $firstLesson = Lesson::where('section_id', $firstSection->id)->first();
                        $lessonId = $firstLesson ? $firstLesson->id : null;
                        $links[$course->id] = $lessonId ? route('lesson', $lessonId) : route('detail', $course->id);
                    } else {
                        $links[$course->id] = route('detail', $course->id);
                    }
                } else {
                    $links[$course->id] = route('detail', $course->id);
                }
            }
        }

        return view('index', compact('title', 'courses', 'enrollmentStatus', 'enrollments', 'links'));
    }


    public function detail($course_id)
    {
        $course = Course::with('sections.lessons.quizzes')->findOrFail($course_id);

        $sections = $course->sections;
        $lessons = $sections->flatMap->lessons;
        $quizzes = $lessons->flatMap->quizzes; // Lấy tất cả quizzes

        return view('detail', compact('course', 'sections', 'lessons', 'quizzes'));
    }

    public function lesson($lesson_id)
    {
        $lessons = Lesson::findOrFail($lesson_id);
        $sections = $lessons->section;
        $course = $sections->course;
        $quizzes = Quiz::where('lesson_id', $lesson_id)->get();
        $sections = Section::where('course_id', $course->id)->with('lessons')->get();

        $allLessons = Lesson::whereIn('section_id', $sections->pluck('id'))->orderBy('id')->get();
        $currentIndex = $allLessons->search(fn($item) => $item->id == $lessons->id);
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        return view('lesson', compact('lessons', 'sections', 'prevLesson', 'nextLesson', 'quizzes'));
    }

    public function showQuiz($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $section = $lesson->section;
        $course = $section->course;

        $quizzes = Quiz::where('lesson_id', $lessonId)->with(['questions.answers' => function ($query) {
            $query->orderBy('is_correct', 'desc');
        }])->get();

        $userId = Auth::check() ? Auth::id() : null;
        $isEnrolled = false;
        if ($userId && $course) {
            $isEnrolled = Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('showquizz', compact('lesson', 'quizzes', 'isEnrolled', 'course'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        if (!$request->has('answers')) {
            return redirect()->route('quizzes', $quiz->lesson_id)
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
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('quizzes', $quiz->lesson_id)
                ->with('error', 'Bạn cần đăng nhập để làm bài quiz!');
        }

        UserQuizResult::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'submitted_at' => now(),
        ]);

        return redirect()->route('quizzes', $quiz->lesson_id)
            ->with('success', "Bạn đã trả lời $correctAnswers/$totalQuestions câu! Điểm: $score%");
    }
}
