<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{
    protected $fillable = ['question_id', 'answer_text', 'is_correct', 'user_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function scopeOfTeacher($query)
    {
        return $query->where('user_id', Auth::id())
            ->whereHas('question', function ($q) {
                $q->where('user_id', Auth::id());
            });
    }
}