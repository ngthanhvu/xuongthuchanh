<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Section extends Model
{
    protected $fillable = ['course_id', 'title', 'user_id']; // Thêm user_id nếu dùng cách 2

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function scopeOfTeacher($query)
    {
        return $query->whereHas('course', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }
}