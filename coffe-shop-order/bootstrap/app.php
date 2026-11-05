
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\QueryException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Aktifkan session dan cookie untuk autentikasi Sanctum
        $middleware->statefulApi();

        // Middleware role
        $middleware->alias([
            'role' => \App\Http\Middleware\CekRole::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->report(function (Throwable $e) {
            // Log error Laravel
        });

        $exceptions->render(function (Throwable $e, Request $request) {

            if (!$request->is('api/*')) {
                return null;
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint API tidak ditemukan.',
                ], 404);
            }

            if ($e instanceof AccessDeniedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu tidak memiliki izin untuk mengakses data ini.',
                ], 403);
            }

            if ($e instanceof QueryException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi masalah saat memproses data database.',
                ], 500);
            }

            if ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();

                if (in_array($status, [403, 404, 405, 500], true)) {
                    return response()->json([
                        'success' => false,
                        'message' => match ($status) {
                            403 => 'Akses ditolak.',
                            404 => 'Endpoint API tidak ditemukan.',
                            405 => 'Metode permintaan tidak diizinkan.',
                            500 => 'Terjadi kesalahan pada server.',
                        },
                    ], $status);
                }
            }

            return null;
        });

    })->create();
