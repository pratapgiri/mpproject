<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\VerifyAuthToken;
use App\Http\Middleware\TokenExpiryMiddleware;
use App\Http\Middleware\UserActiveMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verifyAuthToken' => VerifyAuthToken::class,
            'tokenExpiryMiddleware' => TokenExpiryMiddleware::class,
            'userActiveMiddleware' => UserActiveMiddleware::class,
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,

        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();