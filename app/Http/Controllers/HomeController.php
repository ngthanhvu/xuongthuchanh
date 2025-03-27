<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
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
        $course = Course::with('sections.lessons')->findOrFail($course_id);

        $sections = $course->sections;

        $lessons = $course->sections->flatMap(function ($section) {
            return $section->lessons;
        });

        return view('detail', compact('course', 'sections', 'lessons'));
    }

    public function lesson($id)
    {
        $lesson = Lesson::with('section.course')->findOrFail($id);

        $course = $lesson->section->course;

        $sections = $course->sections()->with('lessons')->get();

        $totalLessons = $sections->flatMap->lessons->count();

        $allLessons = $sections->flatMap->lessons;
        $currentLessonIndex = $allLessons->search(function ($item) use ($id) {
            return $item->id == $id;
        });

        $previousLesson = $currentLessonIndex > 0 ? $allLessons[$currentLessonIndex - 1] : null;
        $nextLesson = $currentLessonIndex < $totalLessons - 1 ? $allLessons[$currentLessonIndex + 1] : null;

        return view('lessons', compact('lesson', 'course', 'sections', 'totalLessons', 'currentLessonIndex', 'previousLesson', 'nextLesson'));
    }
}
