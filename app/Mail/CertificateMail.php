<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;
    public $completed_at;

    public function __construct($user, $course, $completed_at)
    {
        $this->user = $user;
        $this->course = $course;
        $this->completed_at = $completed_at;
    }

    public function build()
    {
        return $this->view('emails.certificate')
                    ->subject('Chúc mừng! Bạn đã hoàn thành khóa học ' . $this->course->title);
    }
}