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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'is_seller' => \App\Http\Middleware\IsSeller::class,
            'is_superadmin' => \App\Http\Middleware\IsSuperadmin::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'webhook/xendit',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, \Illuminate\Http\Request $request) {
            if (! $request->expectsJson()) {
                return redirect()->guest(route('login'))->with('warning', 'Silakan login terlebih dahulu untuk melanjutkan.');
            }
        });
    })->create();
