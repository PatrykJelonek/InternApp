<?php

namespace App\Listeners;

use App\Events\UniversityWorkerRejected;
use App\Mail\UniversityWorkerRejectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUniversityWorkerRejectedNotification implements ShouldQueue
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
     * @param UniversityWorkerRejected $event
     *
     * @return void
     */
    public function handle(UniversityWorkerRejected $event)
    {
        Mail::to($event->user)->send(
            new UniversityWorkerRejectedMail($event->university, $event->user, $event->reason)
        );
    }
}
