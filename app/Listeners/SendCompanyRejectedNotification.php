<?php

namespace App\Listeners;

use App\Constants\Constants;
use App\Events\CompanyRejected;
use App\Mail\CompanyRejectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCompanyRejectedNotification implements ShouldQueue
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
     * @param  CompanyRejected  $event
     * @return void
     */
    public function handle(CompanyRejected $event)
    {
        Mail::to($event->user)->send(new CompanyRejectedMail($event->company));
    }
}
