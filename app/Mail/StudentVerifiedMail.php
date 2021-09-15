<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\University;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Student
     */
    public $student;

    public $subject = "Twoja prośba o dołączenie do uczelni została zaakceptowana!";

    /**
     * @var University
     */
    private $university;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, University $university)
    {
        $this->student = $student;
        $this->university = $university;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.university.student_verified_email',
            [
                'fullName' => $this->student->user->full_name,
                'universityName' => $this->university->name
            ]
        );
    }
}
