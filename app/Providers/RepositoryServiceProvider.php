<?php

namespace App\Providers;

use App\Repositories\AgreementRepository;
use App\Repositories\Interfaces\AgreementRepositoryInterface;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\InternshipRepository;
use App\Repositories\OfferRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TasksRepositoryInterface::class,TaskRepository::class);
        $this->app->bind(InternshipRepositoryInterface::class,InternshipRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OfferRepositoryInterface::class, OfferRepository::class);
        $this->app->bind(AgreementRepositoryInterface::class, AgreementRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
