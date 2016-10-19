<?php

namespace App\Providers;

use Illuminate\Auth\RequestGuard;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Auth\Provider\Authorization;
use Laravel\Passport\ClientRepository;
use League\OAuth2\Server\ResourceServer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\TokenRepository;

class PassportDingoProvider extends Authorization
{
    public function authenticate(Request $request, Route $route)
    {
        /*if( ! $user = (new TokenGuard(
                app(ResourceServer::class),
                \Auth::createUserProvider('users'),
                new TokenRepository,
                app(ClientRepository::class),
                app('encrypter')
        ))->user($request))
        {
            throw new UnauthorizedHttpException('Auth', 'Unable');
        }

        tap($this->makeGuard($request), function ($guard) {
            app()->refresh('request', $guard, 'setRequest');
        });*/

        //dd($request->user);

        return $request->user();
    }

    public function getAuthorizationMethod()
    {
        return 'bearer';
    }

    private function makeGuard($request)
    {
        return new RequestGuard(function ($request) {
            return (new TokenGuard(
                app(ResourceServer::class),
                Auth::createUserProvider('users'),
                new TokenRepository,
                app(ClientRepository::class),
                app('encrypter')
            ))->user($request);
        }, $request);
    }
}