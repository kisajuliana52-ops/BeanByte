<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();

        // Gunakan role dan status terbaru dari database, bukan nilai session lama.
        if (
            !$user ||
            strtolower(trim((string) $user->status)) !== 'aktif'
        ) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
        }

        $roleAktif = strtolower(trim((string) $user->role));
        if (!in_array($roleAktif, ['admin', 'kasir', 'pemilik', 'pelanggan'], true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
        }

        $rolesDiizinkan = array_map(
            static fn (string $role): string => strtolower(trim($role)),
            $roles
        );

        $request->session()->put([
            'name' => $user->name,
            'username' => $user->username,
            'role' => $roleAktif,
        ]);

        // Pastikan role pengguna sesuai dengan izin route
        if (!in_array($roleAktif, $rolesDiizinkan, true)) {
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
