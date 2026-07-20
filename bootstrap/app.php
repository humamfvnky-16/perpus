<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'audit'      => \App\Http\Middleware\AuditLog::class,
            '2fa'        => \PragmaRX\Google2FALaravel\Middleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);
        $middleware->throttleApi();
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();
