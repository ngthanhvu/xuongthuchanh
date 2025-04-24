<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedCourse;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class SavedCourseController extends Controller
{
    public function toggleSave($courseId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để lưu khóa học.');
        }

        $saved = SavedCourse::where('user_id', $user->id)
                            ->where('course_id', $courseId)
                            ->first();

        if ($saved) {
            $saved->delete();
            return redirect()->back()->with('info', 'Đã hủy lưu khóa học.');
        } else {
            SavedCourse::create([
                'user_id' => $user->id,
                'course_id' => $courseId
            ]);
            return redirect()->back()->with('success', 'Đã lưu khóa học thành công.');
        }
    }
    public function savedCourses()
{
    $user = auth()->user();

    $courses = $user->savedCourses()->with('user', 'category')->paginate(9);
    $enrollmentStatus = [];
    $links = [];

    foreach ($courses as $course) {
        $enrollmentStatus[$course->id] = $course->enrollments()->where('user_id', $user->id)->exists();
        $links[$course->id] = route('detail', $course->id);
    }

    return view('client.course-list', compact('courses', 'enrollmentStatus', 'links'));
}
}
