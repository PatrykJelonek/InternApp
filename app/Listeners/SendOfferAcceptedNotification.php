<?php

namespace App\Listeners;

use App\Events\OfferAccepted;
use App\Mail\OfferAcceptedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOfferAcceptedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OfferAccepted  $event
     * @return void
     */
    public function handle(OfferAccepted $event)
    {
        Mail::to($event->offer->user)->send(
            new OfferAcceptedMail($event->offer)
        );
    }
}
