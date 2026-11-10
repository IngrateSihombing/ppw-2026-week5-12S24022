
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'soap/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // RFC 7807: Authentication Error
        $exceptions->render(function (
            AuthenticationException $e,
            Request $request
        ) {
            if (!$request->is('api/*')) {
                return null;
            }

            return response()->json([
                'type' => 'about:blank',
                'title' => 'Unauthorized',
                'status' => 401,
                'detail' => 'Autentikasi diperlukan atau token tidak valid.',
            ], 401, [
                'Content-Type' => 'application/problem+json',
            ]);
        });

        // RFC 7807: Validation Error
        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {
            if (!$request->is('api/*')) {
                return null;
            }

            return response()->json([
                'type' => 'about:blank',
                'title' => 'Validation Error',
                'status' => 422,
                'detail' => 'Data yang dikirim tidak memenuhi aturan validasi.',
                'errors' => $e->errors(),
            ], 422, [
                'Content-Type' => 'application/problem+json',
            ]);
        });

    })->create();
