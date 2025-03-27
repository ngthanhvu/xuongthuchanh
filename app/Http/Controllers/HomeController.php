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
        $course = Course::with('sections.lessons.quizzes')->findOrFail($course_id);
    
        $sections = $course->sections;
        $lessons = $sections->flatMap->lessons;
        $quizzes = $lessons->flatMap->quizzes; // Lấy tất cả quizzes
    
        return view('detail', compact('course', 'sections', 'lessons', 'quizzes'));
    }

}
