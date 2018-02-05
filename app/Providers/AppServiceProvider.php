<?php

namespace App\Providers;

use App\Repositories\Contracts\ConfirmContentsRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquents\ConfirmContentsRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Repositories\Eloquents\SurveyRepository;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Eloquents\QuestionRepository;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Eloquents\QuestionChoiceRepository;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use App\Repositories\Eloquents\AnswerRepository;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Repositories\Eloquents\AnswerQuestionRepository;
use App\Repositories\Contracts\ConfirmContentRepositoryInterface;
use App\Repositories\Eloquents\ConfirmContentRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            SurveyRepositoryInterface::class,
            SurveyRepository::class
        );

        $this->app->singleton(
            QuestionRepositoryInterface::class,
            QuestionRepository::class
        );

        $this->app->singleton(
            QuestionChoiceRepositoryInterface::class,
            QuestionChoiceRepository::class
        );

        $this->app->singleton(
            ConfirmContentsRepositoryInterface::class,
            ConfirmContentsRepository::class
        );

        $this->app->singleton(
            AnswerRepositoryInterface::class,
            AnswerRepository::class
        );

        $this->app->singleton(
            AnswerQuestionRepositoryInterface::class,
            AnswerQuestionRepository::class
        );

//        $this->app->instance('log', new \Illuminate\Log\Writer(
//                (new Logger(
//                    $this->app->environment()
//                ))->pushHandler(new StreamHandler(env('CONFIG_LOG_PATH').'/log-'.date('Y-m-d')))
//            )
//        );
    }
}
