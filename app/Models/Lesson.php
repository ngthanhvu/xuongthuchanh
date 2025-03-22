<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['section_id', 'title', 'type', 'content', 'file_url'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
