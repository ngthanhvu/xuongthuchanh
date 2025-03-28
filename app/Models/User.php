<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'fullname', 'avatar', 'role', 'token', 'reset_token', 'reset_token_expires_at'];

    public function generateResetToken()
    {
        $this->reset_token = sprintf("%06d", mt_rand(100000, 999999));
        $this->reset_token_expires_at = now()->addMinutes(15);
        $this->save();

        return $this->reset_token;
    }

    public function verifyResetToken($token)
    {
        return $this->reset_token === $token && 
               $this->reset_token_expires_at > now();
    }

    public function clearResetToken()
    {
        $this->reset_token = null;
        $this->reset_token_expires_at = null;
        $this->save();
    }

    public function sendPasswordResetEmail()
    {
        $otp = $this->generateResetToken();

        Mail::send('emails.password-reset', ['otp' => $otp], function($message) {
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
