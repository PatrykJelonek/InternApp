<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyWorkerRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Twoja prośba o dołączenie do firmy została odrzucona!";

    /**
     * @var Company
     */
    private $company;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company, User $user, string $reason)
    {
        $this->company = $company;
        $this->user = $user;
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
            'emails.company.company_worker_rejected_email',
            [
                'fullName' => $this->user->full_name,
                'companyName' => $this->company->name,
                'reason' => $this->reason,
            ]
        );
    }
}
