<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['title', 'description', 'user_id', 'thumbnail', 'price', 'is_free', 'categories_id', 'id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function progress()
    {
        return $this->hasMany(UserCourseProgress::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_course_progress')
            ->withPivot('progress', 'status', 'completed_lessons', 'completed_at')
            ->withTimestamps();
    }

    public function getUserProgress($user)
    {
        $progress = $this->users()->where('user_id', $user->id)->first();
        return $progress ? $progress->pivot->progress : 0;
    }
    public function isSavedByUser($userId)
    {
        return $this->savedByUsers()->where('user_id', $userId)->exists();
    }

    // Add relationship to users who saved this course
    public function savedByUsers()
    {
        return $this->hasMany(SavedCourse::class);
    }

   

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
