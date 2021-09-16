<?php

namespace App\Mail;

use App\Models\University;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UniversityWorkerVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Twoja prośba o dołączenie do uczelni została zaakceptowana!";

    /**
     * @var University
     */
    private $university;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(University $university, User $user)
    {
        $this->university = $university;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.university.university_worker_verified_email',
            [
                'fullName' => $this->user->full_name,
                'universityName' => $this->university->name,
            ]
        );
    }
}
