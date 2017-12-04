<?php

namespace App\Providers;

use App\Repositories\Contracts\PostEloquentRepository;
use App\Repositories\Contracts\UserEloquentRepository;
use App\Respositories\ClassifyRepositoty\PostRepositoryInterface;
use App\Respositories\ClassifyRepositoty\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->singleton(
            PostRepositoryInterface::class,
            PostEloquentRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserEloquentRepository::class
        );
    }
}
