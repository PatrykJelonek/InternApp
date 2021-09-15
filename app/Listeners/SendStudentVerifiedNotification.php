<?php

namespace App\Listeners;

use App\Events\StudentVerified;
use App\Mail\StudentVerifiedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendStudentVerifiedNotification implements ShouldQueue
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
     * @param  StudentVerified  $event
     * @return void
     */
    public function handle(StudentVerified $event)
    {
        Mail::to($event->student->user)->send(new StudentVerifiedMail($event->student, $event->university));
    }
}
