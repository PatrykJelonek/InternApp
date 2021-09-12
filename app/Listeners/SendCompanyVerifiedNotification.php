<?php

namespace App\Listeners;

use App\Constants\Constants;
use App\Events\CompanyVerified;
use App\Mail\CompanyVerifiedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCompanyVerifiedNotification implements ShouldQueue
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
     * @param  CompanyVerified  $event
     * @return void
     */
    public function handle(CompanyVerified $event): void
    {
        Mail::to($event->user)->send(new CompanyVerifiedMail($event->company));
    }
}
