<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'question_text', 'user_id'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeOfTeacher($query)
    {
        return $query->where('user_id', Auth::id())
            ->whereHas('quiz', function ($q) {
                $q->where('user_id', Auth::id())
                    ->whereHas('lesson', function ($q) {
                        $q->where('user_id', Auth::id());
                    });
            });
    }
}
