<?php

namespace App\Providers;

use App\Repositories\Interfaces\InternshipRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use App\Repositories\InternshipRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TaskRepository;
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
