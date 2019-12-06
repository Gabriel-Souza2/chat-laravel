<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Contracts\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Contracts\Repositories\EmailTokenRepositoryInterface',
            'App\Repositories\EmailTokenRepository'
        );

        $this->app->bind(
            'App\Contracts\Middleware\CheckTokenInterface',
            'App\Repositories\EmailTokenRepository'
        );

        $this->app->bind(
            'App\Contracts\Repositories\ResetPasswordRepositoryInterface',
            'App\Repositories\ResetPasswordRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
