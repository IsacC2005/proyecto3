<?php

namespace App\Providers;

use App\Repositories\interfaces\TeacherInterface;
use App\Repositories\interfaces\UserInterface;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class,  UserRepository::class);
        $this->app->bind(TeacherInterface::class, TeacherRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
