<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
