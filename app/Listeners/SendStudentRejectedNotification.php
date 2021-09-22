<?php

namespace App\Listeners;

use App\Events\StudentRejected;
use App\Mail\StudentRejectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendStudentRejectedNotification implements ShouldQueue
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
     * @param  StudentRejected  $event
     * @return void
     */
    public function handle(StudentRejected $event)
    {
        Mail::to($event->student->user)->send(new StudentRejectedMail($event->student, $event->university, $event->reason));
    }
}
