<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Listeners\SendActivationEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\SendStudentRegisteredNotificationEmail;
use App\Events\StudentRegistered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
        StudentRegistered::class => [
            SendStudentRegisteredNotificationEmail::class
        ],
        UserCreated::class => [
            SendActivationEmail::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
