<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pesanan;

class PesananPolicy
{
    // Melihat daftar pesanan
    public function viewAny(User $user): bool
    {
        return in_array(strtolower($user->role), [
            'admin',
            'pemilik',
            'kasir'
        ]);
    }

    // Melihat satu pesanan (Anti-IDOR)
    public function view(User $user, Pesanan $pesanan): bool
    {
        if (in_array(strtolower($user->role), [
            'admin',
            'pemilik',
            'kasir'
        ])) {
            return true;
        }

        if (strtolower($user->role) === 'pelanggan') {
            return $user->id_pelanggan !== null
                && (int) $user->id_pelanggan === (int) $pesanan->id_pelanggan;
        }

        return false;
    }

    // Memperbarui pesanan
    public function update(User $user, Pesanan $pesanan): bool
    {
        return in_array(strtolower($user->role), [
            'admin',
            'pemilik',
            'kasir'
        ]);
    }

    // Menghapus pesanan
    public function delete(User $user, Pesanan $pesanan): bool
    {
        return in_array(strtolower($user->role), [
            'admin',
            'pemilik'
        ]);
    }
}