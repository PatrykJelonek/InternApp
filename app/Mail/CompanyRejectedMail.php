<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Twoja prośba o dodanie firmy do serwisu InternApp została zaakceptowana.';

    /**
     * @var Company
     */
    public $company;

    /**
     * @var string
     */
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param Company $company
     * @param string  $reason
     */
    public function __construct(Company $company, string $reason)
    {
        $this->company = $company;
        $this->reason = $reason;
        $this->subject = "Twoja prośba o dodanie firmy $company->name została zaakceptowana.";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.company.company_rejected_email',
            [
                'companyName' => $this->company->name,
                'reason' => $this->reason
            ]
        );
    }
}
