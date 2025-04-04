<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    protected $fillable = ['lesson_id', 'user_id', 'title', 'description'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function userQuizResults()
    {
        return $this->hasMany(UserQuizResult::class);
    }

    public function isCompletedBy($user)
    {
        return $this->userQuizResults()->where('user_id', $user->id)->exists();
    }

    public function getUserScore($user)
    {
        $result = $this->userQuizResults()->where('user_id', $user->id)->first();
        return $result ? $result->score : null;
    }

    // Scope để lọc quiz của teacher hiện tại
    public function scopeOfTeacher($query)
    {
        return $query->where('user_id', Auth::id())
            ->whereHas('lesson', function ($q) {
                $q->whereHas('section', function ($q) {
                    $q->whereHas('course', function ($q) {
                        $q->where('user_id', Auth::id());
                    });
                });
            });
    }
}