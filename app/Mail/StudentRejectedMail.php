<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\University;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Student
     */
    public $student;

    /**
     * @var University
     */
    public $university;

    /**
     * @var string
     */
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, University $university, string $reason)
    {
        $this->student = $student;
        $this->university = $university;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.university.student_rejected_email',
            [
                'fullName' => $this->student->user->full_name,
                'universityName' => $this->university->name,
                'reason' => $this->reason,
            ]
        );
    }
}
