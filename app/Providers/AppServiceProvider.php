<?php

namespace App\Providers;

use App\Models\Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Relations\Relation;
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

        Relation::morphMap([
            'clients' => Client::class
        ]);
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
