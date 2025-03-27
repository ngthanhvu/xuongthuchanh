<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Lesson;

class CheckEnrollment
{
    public function handle(Request $request, Closure $next)
    {
        $userId = Auth::id();
        $lessonId = $request->route('lesson_id');
        $lesson = Lesson::with('section.course')->findOrFail($lessonId);
        $courseId = $lesson->section->course->id;

        $isEnrolled = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('index')->with('error', 'Bạn chưa đăng ký khóa học này.');
        }

        return $next($request);
    }
}
