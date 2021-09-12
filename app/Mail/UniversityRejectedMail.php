<?php

namespace App\Mail;

use App\Models\University;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UniversityRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Twoja prośba o dodanie uczelni do serwisu InternApp została odrzucona.';

    /**
     * @var University
     */
    private $university;

    /**
     * @var string
     */
    private $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(University $university, string $reason)
    {
        $this->university = $university;
        $this->reason = $reason;
        $this->subject = "Twoja prośba o dodanie uczelni $university->name została odrzucona!";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): UniversityRejectedMail
    {
        return $this->markdown(
            'emails.university.university_rejected_email',
            [
                'universityName' => $this->university->name,
                'reason' => $this->reason,
            ]
        );
    }
}
