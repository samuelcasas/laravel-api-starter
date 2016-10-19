<?php

namespace App\Providers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('Dingo\Api\Exception\Handler')->register(function (AuthenticationException $exception) {
            throw new UnauthorizedHttpException('Token','Unauthenticated', $exception);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
