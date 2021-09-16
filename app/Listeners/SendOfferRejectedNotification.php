<?php

namespace App\Listeners;

use App\Events\OfferRejected;
use App\Mail\OfferRejectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOfferRejectedNotification
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
     * @param  OfferRejected  $event
     * @return void
     */
    public function handle(OfferRejected $event)
    {
        Mail::to($event->offer->user)->send(
            new OfferRejectedMail($event->offer, $event->reason)
        );
    }
}
