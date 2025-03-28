<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Course;

class CourseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course;

    /**
     * Create a new message instance.
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Xác nhận đăng ký khóa học')
                    ->view('emails.CoureConfirmation')
                    ->with([
                        'courseTitle' => $this->course->title,
                        'courseId' => $this->course->id,
                        'price' => number_format($this->course->price, 0, ',', '.') . ' VND', 
                    ]);
    }
}
