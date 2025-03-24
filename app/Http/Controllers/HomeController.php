<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
        $course = Course::all(); 
        return view('index', compact('title', 'course')); 
    }
    

    public function detail($course_id)
    {
        // Lấy course cùng với sections và lessons
        $course = Course::with('sections.lessons')->findOrFail($course_id);

        // Lấy sections từ course
        $sections = $course->sections;

        // Lấy tất cả lessons từ các sections
        $lessons = $course->sections->flatMap(function ($section) {
            return $section->lessons;
        });

        return view('detail', compact('course', 'sections', 'lessons'));
    }
}
