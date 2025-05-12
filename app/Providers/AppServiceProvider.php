<?php

namespace App\Providers;

use App\Interfaces\Authentication\AuthenticationInterface;
use App\Interfaces\Comments\CommetInterface;
use App\Interfaces\Statuses\StatusInterface;
use App\Interfaces\Tasks\TaskInterface;
use App\Services\Authentication\AuthenticationService;
use App\Services\Comments\CommentService;
use App\Services\Statuses\StatusService;
use App\Services\Tasks\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ##################################### Authentication ###################################
        $this->app->bind(AuthenticationInterface::class,AuthenticationService::class);
        ###################################### Task ############################################
        $this->app->bind(TaskInterface::class,TaskService::class);
        ###################################### Status ###########################################
        $this->app->bind(StatusInterface::class,StatusService::class);
        ######################################### Comment #######################################
        $this->app->bind(CommetInterface::class,CommentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
