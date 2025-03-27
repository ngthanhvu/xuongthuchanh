<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Section;
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
        if ($userId) {
            foreach ($courses as $course) {
                $isEnrolled = Enrollment::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->exists();
                $enrollmentStatus[$course->id] = $isEnrolled;
            }
        }

        return view('index', compact('title', 'courses', 'enrollmentStatus', 'enrollments'));
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
        $sections = Section::all();
        $lesson = Lesson::with('quizzes')->findOrFail($lesson_id);

        $allLessons = Lesson::all();
        $currentIndex = $allLessons->pluck('id')->search($lesson_id);

        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < count($allLessons) - 1 ? $allLessons[$currentIndex + 1] : null;
        return view('lesson', compact('lesson', 'sections', 'prevLesson', 'nextLesson'));
    }
}
