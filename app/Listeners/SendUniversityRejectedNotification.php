<?php

namespace App\Listeners;

use App\Constants\Constants;
use App\Events\UniversityRejected;
use App\Mail\UniversityRejectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUniversityRejectedNotification implements ShouldQueue
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
     * @param UniversityRejected $event
     *
     * @return void
     */
    public function handle(UniversityRejected $event): void
    {
        Mail::to($event->user)->send(new UniversityRejectedMail($event->university, $event->reason));
    }
}
