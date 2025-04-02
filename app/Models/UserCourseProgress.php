<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    protected $fillable = ['user_id', 'course_id', 'progress', 'status', 'completed_at', 'completed_lessons'];
    protected $casts = [
        'completed_at' => 'datetime', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}