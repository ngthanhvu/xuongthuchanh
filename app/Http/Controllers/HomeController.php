<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
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

        return view('index', compact('title', 'courses', 'enrollmentStatus'));
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
}
