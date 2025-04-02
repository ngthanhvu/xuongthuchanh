<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\UserQuizResult;
use App\Models\UserCourseProgress;

use \Carbon\Carbon;
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
        $courseProgress = [];

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

        if ($userId) {
            foreach ($courses as $course) {
                $progress = UserCourseProgress::where('course_id', $course->id)->where('user_id', $userId)->first();
                $courseProgress[$course->id] = $progress ? $progress->progress : 0;
            }
        }

        return view('index', compact('title', 'courses', 'enrollmentStatus', 'enrollments', 'links', 'courseProgress'));
    }


    public function detail($course_id)
    {
        $course = Course::with('sections.lessons.quizzes')->findOrFail($course_id);

        $sections = $course->sections;
        $lessons = $sections->flatMap->lessons;
        $quizzes = $lessons->flatMap->quizzes; 

        return view('detail', compact('course', 'sections', 'lessons', 'quizzes'));
    }

    public function loading($course_id)
    {
        $course = Course::with('sections.lessons.quizzes')->findOrFail($course_id);

        $sections = $course->sections;
        $lessons = $sections->flatMap->lessons;
        $quizzes = $lessons->flatMap->quizzes;
        return view('loading', compact('course', 'sections', 'lessons', 'quizzes'));
    }

    public function lesson($lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $section = $lesson->section;
        $course = $section->course;

        $quizzes = Quiz::where('lesson_id', $lesson_id)->get();
        $sections = Section::where('course_id', $course->id)->with('lessons')->get();

        $allLessons = Lesson::whereIn('section_id', $sections->pluck('id'))->orderBy('id')->get();
        $currentIndex = $allLessons->search(fn($item) => $item->id == $lesson->id);
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        $totalLessons = $sections->sum(fn($section) => $section->lessons->count());

        $courseProgress = UserCourseProgress::firstOrCreate(
            ['user_id' => Auth::id(), 'course_id' => $course->id],
            ['progress' => 0, 'status' => 'in_progress', 'completed_lessons' => json_encode([])]
        );

        $progress = $courseProgress->progress;

        return view('lesson', compact('lesson', 'sections', 'prevLesson', 'nextLesson', 'quizzes', 'progress'));
    }

    public function completeLesson(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        $course = $lesson->section->course;

        $sections = Section::where('course_id', $course->id)->with('lessons')->get();
        $totalLessons = $sections->sum(fn($section) => $section->lessons->count());

        $courseProgress = UserCourseProgress::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['progress' => 0, 'status' => 'in_progress', 'completed_lessons' => json_encode([])]
        );

        $completedLessons = json_decode($courseProgress->completed_lessons, true) ?? [];
        if (!in_array($lesson->id, $completedLessons)) {
            $completedLessons[] = $lesson->id;
            $newProgress = $totalLessons > 0 ? round((count($completedLessons) / $totalLessons) * 100) : 0;

            $courseProgress->update([
                'progress' => min($newProgress, 100),
                'status' => $newProgress >= 100 ? 'completed' : 'in_progress',
                'completed_at' => $newProgress >= 100 ? now() : $courseProgress->completed_at,
                'completed_lessons' => json_encode($completedLessons),
            ]);
        }

        return redirect()->route('lesson', $lesson->id)->with('success', 'Bài học đã hoàn thành!');
    }

    public function nextLesson(Request $request, $next_lesson_id = null)
    {
        $currentLessonId = $request->input('current_lesson_id');
        $currentLesson = Lesson::findOrFail($currentLessonId);
        $course = $currentLesson->section->course;

        $sections = Section::where('course_id', $course->id)->with('lessons')->get();
        $allLessons = Lesson::whereIn('section_id', $sections->pluck('id'))->orderBy('id')->get();
        $totalLessons = $sections->sum(fn($section) => $section->lessons->count());
        $currentIndex = $allLessons->search(fn($item) => $item->id == $currentLesson->id);
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        $courseProgress = UserCourseProgress::firstOrCreate(
            ['user_id' => Auth::id(), 'course_id' => $course->id],
            ['progress' => 0, 'status' => 'in_progress', 'completed_lessons' => json_encode([])]
        );

        $completedLessons = json_decode($courseProgress->completed_lessons, true) ?? [];
        if (!in_array($currentLesson->id, $completedLessons)) {
            $completedLessons[] = $currentLesson->id;
            $newProgress = $totalLessons > 0 ? round((count($completedLessons) / $totalLessons) * 100) : 0;

            $courseProgress->update([
                'progress' => min($newProgress, 100),
                'status' => $newProgress >= 100 ? 'completed' : 'in_progress',
                'completed_at' => $newProgress >= 100 ? now() : $courseProgress->completed_at,
                'completed_lessons' => json_encode($completedLessons),
            ]);
        }

        // Kiểm tra bài cuối cùng
        if (!$nextLesson) {
            return redirect()->route('lesson', $currentLesson->id)
                ->with('success', 'Bạn đã hoàn thành toàn bộ khóa học!');
        }

        return redirect()->route('lesson', $next_lesson_id)
            ->with('success', 'Đã chuyển sang bài học tiếp theo!');
    }

    public function showQuiz($lessonId)
    {
        $title = "Bài kiểm tra";
        $lesson = Lesson::findOrFail($lessonId);
        $section = $lesson->section;
        $course = $section->course;

        $quizzes = Quiz::where('lesson_id', $lessonId)
            ->with(['questions.answers' => function ($query) {
                $query->orderBy('is_correct', 'desc');
            }])->get();

        $userId = Auth::id();
        $isEnrolled = false;
        $userQuizResult = null;
        $selectedAnswers = [];
        $answerResults = [];
        $quizCompleted = false;

        if ($userId && $course) {
            $isEnrolled = Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->exists();

            $userQuizResult = UserQuizResult::where('user_id', $userId)
                ->whereIn('quiz_id', $quizzes->pluck('id'))
                ->orderByDesc('submitted_at')
                ->first();

            if ($userQuizResult && $userQuizResult->score >= 100) {
                $quizCompleted = true;
                foreach ($quizzes as $quiz) {
                    foreach ($quiz->questions as $question) {
                        $correctAnswer = $question->answers->where('is_correct', true)->first();
                        if ($correctAnswer) {
                            $selectedAnswers[$question->id] = $correctAnswer->id;
                            $answerResults[$question->id] = 'correct';
                        }
                    }
                }
            }
        }
//update user quizz result nộp bài update lại dữ liệu
        return view('showquizz', compact(
            'lesson',
            'quizzes',
            'isEnrolled',
            'course',
            'userQuizResult',
            'selectedAnswers',
            'answerResults',
            'quizCompleted',
            'title'
        ));
    }


    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $userId = Auth::id();

        $existingResult = UserQuizResult::where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->where('score', '>=', 100)
            ->first();

        if ($existingResult) {
            return redirect()->route('quizzes', $quiz->lesson_id)
                ->with('error', 'Bạn đã hoàn thành bài kiểm tra này rồi!');
        }

        if (!$request->has('answers')) {
            return redirect()->route('quizzes', $quiz->lesson_id)
                ->with('error', 'Bạn chưa chọn đáp án nào!');
        }

        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();

        if (!$userId) {
            return redirect()->route('quizzes', $quiz->lesson_id)
                ->with('error', 'Bạn cần đăng nhập để làm bài quiz!');
        }

        $selectedAnswers = $request->answers;
        $answerResults = [];

        foreach ($quiz->questions as $question) {
            if (isset($selectedAnswers[$question->id])) {
                $selectedAnswerId = $selectedAnswers[$question->id];
                $correctAnswer = $question->answers->where('is_correct', true)->first();

                if ($correctAnswer && $correctAnswer->id == $selectedAnswerId) {
                    $correctAnswers++;
                    $answerResults[$question->id] = 'correct';
                } else {
                    $answerResults[$question->id] = 'incorrect';
                }
            } else {
                $answerResults[$question->id] = 'unanswered';
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        $userQuizResult = UserQuizResult::updateOrCreate(
            ['user_id' => $userId, 'quiz_id' => $quiz->id],
            ['score' => $score, 'submitted_at' => now()]
        );

        if ($score >= 100) {
            return redirect()->route('quizzes', $quiz->lesson_id)
                ->with('success', "🎉 Chúc mừng! Bạn đã hoàn thành bài kiểm tra với số điểm {$score}%!")
                ->with('selectedAnswers', $selectedAnswers)
                ->with('answerResults', $answerResults);
        } else {
            return redirect()->route('quizzes', $quiz->lesson_id)
                ->with('error', "Bạn chỉ đạt {$score}%. Hãy xem lại câu sai.")
                ->with('selectedAnswers', $selectedAnswers)
                ->with('answerResults', $answerResults);
        }
    }

    public function reveal()
    {
        $title = 'Lộ trình học tập';
        $user = Auth::user();
        $courses = $user->enrolledCourses()->with('sections.lessons.quizzes')->get();
        $course = Course::with('sections.lessons.quizzes')->first();
        foreach ($courses as $course) {
            if ($course->pivot->status === 'completed' && $course->pivot->completed_at) {
                $course->pivot->completed_at = Carbon::parse($course->pivot->completed_at);
            }
            $course->firstLesson = $course->sections->flatMap->lessons->first();

        }

        return view('reveal', compact('courses', 'course', 'title')); // Hoặc 'reveal'
    }
}
