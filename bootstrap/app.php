<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            Log::error('Model not found', [
               'message' => $e->getMessage(),
               'input' => $request->all(),
            ]);

            return response()->json([
                'status' => 'fail',
                'message' => 'NOT_FOUND_RESOURCE',
            ], 404);
        });

        $exceptions->render(function (ValidationException $e, $request) {
            Log::error('Validation failed', [
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'status' => 'fail',
                'message' => 'VALIDATION_FAILED',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (Throwable $e) {
            Log::error('Unhandled exception', [
                'message' => $e->getMessage(),
                'input' => request()->all(),
            ]);

            return response()->json([
                'status' => 'fail',
                'message' => 'INTERNAL_SERVER_ERROR',
            ], 500);
        });
    })->create();
