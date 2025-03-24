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
        $title = 'Trang chủ'; // Title for the page
        $course = Course::all(); // Fetch all courses or modify as needed

        return view('index', compact('title', 'course')); // Pass data to view
    }

    public function detail($course_id)
    {
        $course = Course::with('sections.lessons')->findOrFail($course_id);

        $sectionIds = $course->sections->pluck('id')->toArray();

        $lessonIds = $course->sections->flatMap(function ($section) {
            return $section->lessons->pluck('id');
        })->toArray();

        return view('detail', compact('course', 'sectionIds', 'lessonIds'));
        // return response()->json([
        //     'course_id' => $course->id,
        //     'section_ids' => $sectionIds,
        //     'lesson_ids' => $lessonIds,
        // ]);
    }
}
