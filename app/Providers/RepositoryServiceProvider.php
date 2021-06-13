<?php

namespace App\Providers;

use App\Repositories\AgreementRepository;
use App\Repositories\AgreementStatusRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\ChatRepository;
use App\Repositories\CityRepository;
use App\Repositories\Interfaces\AgreementRepositoryInterface;
use App\Repositories\Interfaces\AgreementStatusRepositoryInterface;
use App\Repositories\Interfaces\AttachmentRepositoryInterface;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use App\Repositories\Interfaces\OfferCategoryRepositoryInterface;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Repositories\Interfaces\OfferStatusRepositoryInterface;
use App\Repositories\Interfaces\QuestionnairesRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\InternshipRepository;
use App\Repositories\OfferCategoryRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OfferStatusRepository;
use App\Repositories\QuestionnairesRepository;
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
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(OfferStatusRepositoryInterface::class, OfferStatusRepository::class);
        $this->app->bind(OfferCategoryRepositoryInterface::class, OfferCategoryRepository::class);
        $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
        $this->app->bind(AgreementStatusRepositoryInterface::class, AgreementStatusRepository::class);
        $this->app->bind(ChatRepositoryInterface::class, ChatRepository::class);
        $this->app->bind(QuestionnairesRepositoryInterface::class, QuestionnairesRepository::class);
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
