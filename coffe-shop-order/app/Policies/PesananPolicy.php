<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pesanan;

class PesananPolicy
{
    private function pegawai(User $user): bool
    {
        return in_array(strtolower($user->role), [
            'admin',
            'pemilik',
            'kasir'
        ]);
    }

    public function viewAny(User $user): bool
    {
        return $this->pegawai($user);
    }

    public function view(User $user, Pesanan $pesanan): bool
    {
        return $this->pegawai($user);
    }

    public function update(User $user, Pesanan $pesanan): bool
    {
        return $this->pegawai($user);
    }

    public function delete(User $user, Pesanan $pesanan): bool
    {
        return $this->pegawai($user);
    }
}
