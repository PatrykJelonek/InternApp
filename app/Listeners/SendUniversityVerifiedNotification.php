<?php

namespace App\Listeners;

use App\Constants\Constants;
use App\Events\UniversityVerified;
use App\Mail\UniversityVerifiedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUniversityVerifiedNotification implements ShouldQueue
{
    public $queue = Constants::QUEUE_NAME_NOTIFICATIONS;

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
     * @param  UniversityVerified  $event
     * @return void
     */
    public function handle(UniversityVerified $event)
    {
        Mail::to($event->user)->send(new UniversityVerifiedMail($event->university));
    }
}
