<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'fullname',
        'avatar',
        'role',
        'token',
        'reset_token',
        'reset_token_expires_at',
        'qualifications',
        'is_teacher_requested',
        'teacher_request_status',
        'teacher_request_message'
    ];
    public function generateResetToken()
    {
        $this->reset_token = sprintf("%06d", mt_rand(100000, 999999));
        $this->reset_token_expires_at = now()->addMinutes(15);
        $this->save();

        return $this->reset_token;
    }

    public function verifyResetToken($token)
    {
        if (!$this->reset_token) {
            return false;
        }

        if ($this->reset_token !== $token) {
            return false;
        }

        $isValid = $this->reset_token_expires_at &&
            $this->reset_token_expires_at > now();

        if ($isValid) {
            return true;
        }

        return false;
    }

    public function clearResetToken()
    {
        $this->reset_token = null;
        $this->reset_token_expires_at = null;
        $this->save();
    }

    public function sendPasswordResetEmail()
    {
        $this->clearResetToken();

        $otp = $this->generateResetToken();

        Mail::send('emails.password-reset', ['otp' => $otp], function ($message) {
            $message->to($this->email)
                ->subject('Mã OTP Đặt Lại Mật Khẩu');
        });
    }

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

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'user_course_progress')
            ->withPivot('progress', 'status', 'completed_lessons', 'completed_at')
            ->withTimestamps();
    }
}
