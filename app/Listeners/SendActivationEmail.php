<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\ActivationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail implements ShouldQueue
{
    public $queue = 'listeners';
    public $tries = 5;

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param UserCreated $event
     *
     * @return void
     */
    public function handle(UserCreated $event)
    {
        Mail::to($event->user->email)->send(new ActivationEmail($event->user));
    }

    public function failed(UserCreated $event, $exception)
    {
        Log::channel('api')->error(
            'Wystąpił problem z wysłaniem maila aktywacyjnego!',
            [
                'to' => $event->user->email,
                'exception' => (array) $exception,
            ]
        );
    }
}
