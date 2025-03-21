<?php

namespace App\Http\Controllers;

use App\Models\Course; // Assuming you have a Course model

class Home extends Controller
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
}
