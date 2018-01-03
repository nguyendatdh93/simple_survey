<?php

namespace App\Providers;

use App\Repositories\ContractsRepository\PostEloquentRepository;
use App\Repositories\ContractsRepository\UserEloquentRepository;
use App\Repositories\InterfacesRepository\PostInterfaceRepository;
use App\Repositories\InterfacesRepository\UserInterfaceRepository;
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
            UserInterfaceRepository::class,
            UserEloquentRepository::class
        );
    }
}
