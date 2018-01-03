<?php

namespace App\Providers;

use App\Repositories\ContractsRepository\PostEloquentRepository;
use App\Repositories\ContractsRepository\UserEloquentRepository;
use App\Respositories\InterfacesRepository\PostInterfaceRepository;
use App\Respositories\InterfacesRepository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
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
            PostInterfaceRepository::class,
            PostEloquentRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserEloquentRepository::class
        );
    }
}
