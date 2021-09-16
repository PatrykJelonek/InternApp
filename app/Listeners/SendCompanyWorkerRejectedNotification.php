<?php

namespace App\Listeners;

use App\Events\CompanyWorkerRejected;
use App\Events\UniversityWorkerRejected;
use App\Mail\UniversityWorkerRejectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCompanyWorkerRejectedNotification implements ShouldQueue
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
     * @param CompanyWorkerRejected $event
     *
     * @return void
     */
    public function handle(CompanyWorkerRejected $event)
    {
        Mail::to($event->user)->send(
            new UniversityWorkerRejectedMail($event->company, $event->user, $event->reason)
        );
    }
}
