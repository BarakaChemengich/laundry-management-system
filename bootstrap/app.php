<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Register Custom RBAC Routing Middleware Aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\EnforceRole::class,
        ]);

        // 2. Exempt External Machine Handshake Routes from CSRF
        // Safaricom Daraja API callbacks operate statelessly and cannot provide web session cookies.
        $middleware->validateCsrfTokens(except: [
            'mpesa/callback',
            'v1/mpesa/callback'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();