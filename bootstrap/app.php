<?php

use App\Http\Middleware\AuthenticateApiKey;
use App\Http\Middleware\LogApiUsage;
use App\Http\Middleware\RateLimitApiKey;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.api'  => AuthenticateApiKey::class,
            'rate.api'  => RateLimitApiKey::class,
            'log.api'   => LogApiUsage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*') || $request->is('webhooks/*')) {
                return response()->json([
                    'error'   => true,
                    'code'    => 'SERVER_ERROR',
                    'message' => app()->isProduction() ? 'An unexpected error occurred.' : $e->getMessage(),
                ], 500);
            }
        });
    })->create();
