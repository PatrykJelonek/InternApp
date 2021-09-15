<?php

namespace App\Providers;

use App\Events\CompanyRejected;
use App\Events\CompanyVerified;
use App\Events\StudentRejected;
use App\Events\StudentVerified;
use App\Events\UniversityRejected;
use App\Events\UniversityVerified;
use App\Events\UserCreated;
use App\Listeners\SendActivationEmail;
use App\Listeners\SendCompanyRejectedNotification;
use App\Listeners\SendCompanyVerifiedNotification;
use App\Listeners\SendStudentRejectedNotification;
use App\Listeners\SendStudentVerifiedNotification;
use App\Listeners\SendUniversityRejectedNotification;
use App\Listeners\SendUniversityVerifiedNotification;
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
            SendStudentRegisteredNotificationEmail::class,
        ],
        UserCreated::class => [
            SendActivationEmail::class,
        ],
        UniversityRejected::class => [
            SendUniversityRejectedNotification::class,
        ],
        UniversityVerified::class => [
            SendUniversityVerifiedNotification::class,
        ],
        CompanyRejected::class => [
            SendCompanyRejectedNotification::class,
        ],
        CompanyVerified::class => [
            SendCompanyVerifiedNotification::class,
        ],
        StudentVerified::class => [
            SendStudentVerifiedNotification::class,
        ],
        StudentRejected::class => [
            SendStudentRejectedNotification::class,
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
