<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();
        $roleAktif = strtolower(trim((string) ($user?->role ?? '')));
        $rolesDiizinkan = array_map(
            static fn (string $role): string => strtolower(trim($role)),
            $roles
        );

        if (
            !$user ||
            strtolower(trim((string) $user->status)) !== 'aktif' ||
            !in_array($roleAktif, $rolesDiizinkan, true)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.',
            ], 403);
        }

        return $next($request);
    }
}
