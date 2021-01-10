<?php

namespace App\Listeners;

use App\Events\StudentRegistered;
use App\Mail\StudentRegisteredNotificationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendStudentRegisteredNotificationEmail implements ShouldQueue
{
    public $queue = 'emails';

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
     * @param  StudentRegistered  $event
     * @return void
     */
    public function handle(StudentRegistered $event)
    {
        Mail::to('pj210@wp.pl')->send(new StudentRegisteredNotificationEmail($event->student));
    }

    /**
     * @param StudentRegistered $event
     * @param $exception
     */
    public function failed(StudentRegistered $event, $exception)
    {
        Log::channel('api')->error('Wystąpił błąd podczas wysyłania mail\'a o nowym studencie!');
        clock()->error('Wystąpił błąd podczas wysyłania mail\'a o nowym studencie!');
    }
}
