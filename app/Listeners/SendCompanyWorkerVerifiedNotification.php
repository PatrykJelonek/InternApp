<?php

namespace App\Listeners;

use App\Events\CompanyWorkerVerified;
use App\Events\UniversityWorkerVerified;
use App\Mail\UniversityWorkerVerifiedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCompanyWorkerVerifiedNotification implements ShouldQueue
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
     * @param  CompanyWorkerVerified  $event
     * @return void
     */
    public function handle(CompanyWorkerVerified $event)
    {
        Mail::to($event->user)->send(new UniversityWorkerVerifiedMail($event->company, $event->user));
    }
}
