<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'fullname', 'avatar', 'role'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function hasEnrolled($courseId)
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->exists();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function quizResults()
    {
        return $this->hasMany(UserQuizResult::class);
    }
}
