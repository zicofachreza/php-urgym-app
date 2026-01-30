<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $message = 'Resource not found.';
                $previous = $e->getPrevious();

                // Cek apakah error ini disebabkan oleh Model yang tidak ditemukan (Route Model Binding)
                if ($previous instanceof ModelNotFoundException) {
                    $modelPath = $previous->getModel(); // Mendapatkan nama class model (ex: App\Models\GymClass)
                    $modelName = class_basename($modelPath);   // Mengambil nama terakhir saja (ex: GymClass)

                    // Mengubah CamelCase menjadi kata-kata yang mudah dibaca (ex: Gym Class)
                    $readableName = preg_replace('/(?<!^)[A-Z]/', ' $0', $modelName);
                    $message = "{$readableName} not found.";
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $message,
                ], 404);
            }
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid or missing token. Please log in first.',
                ], 401);
            }
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not allowed to cancel this booking.',
                ], 403);
            }
        });
    })->create();
