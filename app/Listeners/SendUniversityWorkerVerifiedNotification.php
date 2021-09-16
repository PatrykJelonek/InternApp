<?php

namespace App\Listeners;

use App\Events\UniversityWorkerVerified;
use App\Mail\UniversityWorkerVerifiedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUniversityWorkerVerifiedNotification implements ShouldQueue
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
     * @param  UniversityWorkerVerified  $event
     * @return void
     */
    public function handle(UniversityWorkerVerified $event)
    {
        Mail::to($event->user)->send(new UniversityWorkerVerifiedMail($event->university, $event->user));
    }
}
