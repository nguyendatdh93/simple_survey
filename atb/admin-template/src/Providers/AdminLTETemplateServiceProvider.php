<?php

namespace Atb\AdminTemplate\Providers;

use Atb\AdminTemplate\Facades\AdminLTE;
use Atb\AdminTemplate\User\Providers\GuestUserServiceProvider;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdminLTETemplateServiceProvider.
 */
class AdminLTETemplateServiceProvider extends ServiceProvider
{
    use DetectsApplicationNamespace;

    /**
     * Register the application services.
     */
    public function register()
    {
        if (!defined('ADMINLTETEMPLATE_PATH')) {
            define('ADMINLTETEMPLATE_PATH', realpath(__DIR__.'/../../'));
        }

        $this->app->bind('AdminLTE', function () {
            return new \Atb\AdminTemplate\AdminLTE();
        });

        if (config('adminlte.guestuser', true)) {
            $this->registerGuestUserProvider();
        }
        if (config('auth.providers.users.field', 'email') === 'username') {
            $this->loadMigrationsFrom(ADMINLTETEMPLATE_PATH .'/database/migrations/username_login');
        }
    }

    /**
     * Register Guest User Provider.
     */
    protected function registerGuestUserProvider()
    {
        $this->app->register(GuestUserServiceProvider::class);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->defineRoutes();
        //Publish
        $this->publishHomeController();
        $this->changeRegisterController();
        $this->changeLoginController();
        $this->changeForgotPasswordController();
        $this->changeResetPasswordController();
        $this->publishPublicAssets();
        $this->publishViews();
        $this->publishResourceAssets();
        $this->publishTests();
        $this->publishLanguages();
        $this->publishConfig();
        $this->publishWebRoutes();
        $this->publishApiRoutes();
        $this->publishDusk();
        $this->publishDatabaseConfig();
        $this->enableSpatieMenu();
    }

    /**
     * Define the AdminLTETemplate routes.
     */
    protected function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $router = app('router');
            $router->group(['namespace' => $this->getAppNamespace().'Http\Controllers'], function () {
                require __DIR__.'/../Http/routes.php';
            });
        }
    }

    /**
     * Publish Home Controller.
     */
    private function publishHomeController()
    {
        $this->publishes(AdminLTE::homeController(), 'admin');
    }

    /**
     * Change default Laravel RegisterController.
     */
    private function changeRegisterController()
    {
        $this->publishes(AdminLTE::registerController(), 'admin');
    }

    /**
     * Change default Laravel LoginController.
     */
    private function changeLoginController()
    {
        $this->publishes(AdminLTE::loginController(), 'admin');
    }

    /**
     * Change default Laravel forgot password Controller.
     */
    private function changeForgotPasswordController()
    {
        $this->publishes(AdminLTE::forgotPasswordController(), 'admin');
    }

    /**
     * Change default Laravel reset password Controller.
     */
    private function changeResetPasswordController()
    {
        $this->publishes(AdminLTE::resetPasswordController(), 'admin');
    }

    /**
     * Publish public resource assets to Laravel project.
     */
    private function publishPublicAssets()
    {
        $this->publishes(AdminLTE::publicAssets(), 'admin');
    }

    /**
     * Publish package views to Laravel project.
     */
    private function publishViews()
    {

        $this->loadViewsFrom(resource_path('views'), 'admin');

        $this->publishes(AdminLTE::views(), 'admin');
    }

    /**
     * Register a view file namespace.
     *
     * @param  string  $path
     * @param  string  $namespace
     * @return void
     */
    protected function loadViewsFrom($path, $namespace)
    {
        if (is_array($this->app->config['view']['paths'])) {
            foreach ($this->app->config['view']['paths'] as $viewPath) {
                if (is_dir($appPath = $viewPath.'/'.$namespace)) {
                    $this->app['view']->addNamespace($namespace, $appPath);
                }
            }
        }

        $this->app['view']->addNamespace($namespace, $path);
    }

    /**
     * Publish package resource assets to Laravel project.
     */
    private function publishResourceAssets()
    {
        $this->publishes(AdminLTE::resourceAssets(), 'admin');
    }

    /**
     * Publish package tests to Laravel project.
     */
    private function publishTests()
    {
        $this->publishes(AdminLTE::tests(), 'admin');
    }

    /**
     * Publish package language to Laravel project.
     */
    private function publishLanguages()
    {
        $this->loadTranslationsFrom(resource_path('lang'), 'adminlte_lang');
        $this->publishes(AdminLTE::languages(), 'adminlte_lang');
    }


    /**
     * Publish adminlte package config.
     */
    private function publishConfig()
    {
        $this->publishes(AdminLTE::config(), 'admin');
    }

    /**
     * Publish routes/web.php file.
     */
    private function publishWebRoutes()
    {
        $this->publishes(AdminLTE::webroutes(), 'admin');
    }

    /**
     * Publish routes/api.php file.
     */
    private function publishApiRoutes()
    {
        $this->publishes(AdminLTE::apiroutes(), 'admin');
    }

    /**
     * Publish dusk tests files.
     */
    private function publishDusk()
    {
        $this->publishDuskEnvironment();
        $this->publishAppServiceProvider();
    }

    /**
     * Publish dusk environment files.
     */
    private function publishDuskEnvironment()
    {
        $this->publishes(AdminLTE::duskEnvironment(), 'admin');
    }

    /**
     * Publish app/Providers/AppServiceProvider.php file.
     */
    private function publishAppServiceProvider()
    {
        $this->publishes(AdminLTE::appServiceProviderClass(), 'admin');
    }

    /**
     * Publish database config files.
     */
    private function publishDatabaseConfig()
    {
        $this->publishes(AdminLTE::databaseConfig(), 'admin');
    }

    /**
     * Enable (if active) spatie menu.
     */
    private function enableSpatieMenu()
    {
        if ($this->app->getProvider('Spatie\Menu\Laravel\MenuServiceProvider')) {
            require config_path('menu.php');
        }
    }
}
