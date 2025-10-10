<?php

namespace App\Providers;

use App\Repositories\ApiEnrollmentRepository;
use App\Repositories\ApiStudentRepository;
use App\Repositories\ApiTeacherRepository;
use App\Repositories\DailyClassRepository;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\RepresentativeInterface;
use App\Repositories\Interfaces\RoleInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TeacherInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\EnrollmentRepository;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\ItemEvaluationInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\TicketInterface;
use App\Repositories\ItemEvaluationRepository;
use App\Repositories\LearningProjectRepository;
use App\Repositories\RepresentativeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(UserInterface::class,  UserRepository::class);
        $this->app->bind(StudentInterface::class, ApiStudentRepository::class);
        $this->app->bind(RepresentativeInterface::class, RepresentativeRepository::class);
        $this->app->bind(TeacherInterface::class, ApiTeacherRepository::class);
        $this->app->bind(EnrollmentInterface::class, ApiEnrollmentRepository::class);
        $this->app->bind(LearningProjectInterface::class, LearningProjectRepository::class);
        $this->app->bind(DailyClassInterface::class, DailyClassRepository::class);
        $this->app->bind(ItemEvaluationInterface::class, ItemEvaluationRepository::class);
        $this->app->bind(TicketInterface::class, TicketRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
