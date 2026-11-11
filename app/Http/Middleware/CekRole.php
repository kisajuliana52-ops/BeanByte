<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        // Jika belum login, arahkan ke halaman login
        $roleAktif = $request->session()->get('role');

        if (!$roleAktif) {
            return redirect('/login');
        }

        // Pastikan role pengguna sesuai dengan izin route
        if (!in_array($roleAktif, $roles, true)) {
            return redirect('/' . $roleAktif);
        }

        // Cegah halaman terlindungi disimpan di cache browser
        $response = $next($request);

        $response->headers->set(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, max-age=0'
        );

        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
