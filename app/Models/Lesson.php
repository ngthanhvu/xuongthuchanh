<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model
{
    protected $fillable = ['id', 'section_id', 'user_id', 'title', 'type', 'content', 'file_url'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function progress()
    {
        return $this->hasMany(UserCourseProgress::class);
    }

    public function isCompletedBy($user)
    {
        $course = $this->section->course;
        $progress = $course->users()->where('user_id', $user->id)->first();

        if ($progress && $progress->pivot->completed_lessons) {
            $completedLessons = json_decode($progress->pivot->completed_lessons, true);

            if (!is_array($completedLessons)) {
                $completedLessons = [];
            }

            return in_array($this->id, $completedLessons);
        }

        return false;
    }

    public function scopeOfTeacher($query)
    {
        return $query->where('user_id', Auth::id())->whereHas('section', function ($q) {
            $q->whereHas('course', function ($q) {
                $q->where('user_id', Auth::id());
            });
        });
    }
}
