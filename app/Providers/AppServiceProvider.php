<?php

namespace App\Providers;

use App\Repositories\Contracts\PostEloquentRepository;
use App\Respositories\ClassifyRepositoty\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(
            PostRepositoryInterface::class,
            PostEloquentRepository::class
        );
    }
}
