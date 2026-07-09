<?php

use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request as HttpRequest;

HttpRequest::setTrustedProxies(
    ['0.0.0.0/0'],
    HttpRequest::HEADER_X_FORWARDED_FOR |
    HttpRequest::HEADER_X_FORWARDED_HOST |
    HttpRequest::HEADER_X_FORWARDED_PORT |
    HttpRequest::HEADER_X_FORWARDED_PROTO |
    HttpRequest::HEADER_X_FORWARDED_PREFIX |
    HttpRequest::HEADER_X_FORWARDED_AWS_ELB,
);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register the admin auth middleware alias
        $middleware->alias([
            'admin.auth' => AdminAuthenticate::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
