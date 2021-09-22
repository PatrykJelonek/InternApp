<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Offer
     */
    private $offer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.offers.offer_accepted_email',
            [
                'fullName' => $this->offer->user->full_name,
                'offerName' => $this->offer->name,
                'companyName' => $this->offer->company->name
            ]
        );
    }
}
