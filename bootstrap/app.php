<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminRedirect;
use App\Http\Middleware\AdminAuthenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        # Middleware alias
        $middleware->alias([
            'admin.guest' => AdminRedirect::class,
            'admin.auth' => AdminAuthenticate::class,
        ]);

        # Redirect middleware
        $middleware->redirectTo(
            guests :'/admin/login',
            users : '/account/dashboard'
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
