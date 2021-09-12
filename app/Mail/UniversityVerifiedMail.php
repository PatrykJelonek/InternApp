<?php

namespace App\Mail;

use App\Models\University;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UniversityVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Twoja prośba o dodanie uczelni do serwisu InternApp została zaakceptowana.';

    /**
     * @var University
     */
    public $university;

    /**
     * @param University $university
     */
    public function __construct(University $university)
    {
        $this->university = $university;
        $this->subject = "Twoja prośba o dodanie uczelni $university->name została zaakceptowana!";
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.university.university_verified_email',
            [
                'universityName' => $this->university->name,
            ]
        );
    }
}
