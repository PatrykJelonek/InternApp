<?php

namespace App\Mail;

use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentRegisteredNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Student
     */
    public $student;

    /**
     * Create a new message instance.
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.student_registered_notification_email')
            ->from(config('mail.from.address'), 'Nowy student dołączył do Twojej uczelni!')
            ->with([
                'studentFullName' => $this->student->user->first_name . ' ' . $this->student->user->last_name,
            ]);
    }
}
