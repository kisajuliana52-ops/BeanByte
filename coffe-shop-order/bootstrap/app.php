<?php

use Illuminate\Database\ConnectionException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Autentikasi Sanctum
        $middleware->statefulApi();

        // API tanpa login harus mengembalikan JSON, bukan redirect HTML
        $middleware->redirectGuestsTo(function (Request $request) {
            return $request->is('api/*') ? null : '/login';
        });

        // Middleware role
        $middleware->alias([
            'role' => \App\Http\Middleware\CekRole::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->report(function (Throwable $e) {
            // Error tetap dicatat oleh Laravel
        });

        $exceptions->render(function (Throwable $e, Request $request) {

            if (!$request->is('api/*')) {
                return null;
            }

            // Belum login
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                ], 401);
            }

            // Endpoint tidak ditemukan
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint API tidak ditemukan.',
                ], 404);
            }

            // Akses ditolak
            if ($e instanceof AccessDeniedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu tidak memiliki izin mengakses data ini.',
                ], 403);
            }

            // Database bermasalah
            if (
                $e instanceof ConnectionException ||
                $e instanceof QueryException
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Database tidak dapat dihubungi. Pastikan MySQL XAMPP berjalan.',
                ], 503);
            }

            // HTTP error lainnya
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
