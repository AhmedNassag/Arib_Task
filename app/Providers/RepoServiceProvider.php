<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*** start basic data ***/
        //Role
        $this->app->bind(
            'App\Repositories\Dashboard\Role\RoleInterface',
            'App\Repositories\Dashboard\Role\RoleRepository',
        );

        //User
        $this->app->bind(
            'App\Repositories\Dashboard\User\UserInterface',
            'App\Repositories\Dashboard\User\UserRepository',
        );

        //Department
        $this->app->bind(
            'App\Repositories\Dashboard\Department\DepartmentInterface',
            'App\Repositories\Dashboard\Department\DepartmentRepository',
        );

        //Task
        $this->app->bind(
            'App\Repositories\Dashboard\Task\TaskInterface',
            'App\Repositories\Dashboard\Task\TaskRepository',
        );
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
