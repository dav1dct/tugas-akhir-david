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
        // Tambahkan alias middleware role di sini
        $middleware->alias([
            'role' => \App\Http\Middleware\Role::class,
        ]);

        // Kalau ada middleware lain, bisa ditambah di sini
        // $middleware->append(...);
        // $middleware->group('web', [...]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();