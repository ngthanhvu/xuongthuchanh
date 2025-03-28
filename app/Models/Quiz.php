<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['lesson_id', 'title', 'description'];

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
}