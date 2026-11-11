<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPenggunaController extends Controller
{
    public function index()
    {
        return response()->json(
            User::select(
                'id',
                'name',
                'username',
                'email',
                'role',
                'status',
                'created_at'
            )->orderBy('id')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => ['required', Rule::in([
                'admin', 'kasir', 'pemilik', 'pelanggan'
            ])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        return response()->json([
            'message' => 'Akun berhasil dibuat.',
            'data' => $user->only([
                'id', 'name', 'username', 'email', 'role', 'status'
            ]),
        ], 201);
    }

    public function update(Request $request, User $pengguna)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required', 'string', 'max:50', 'alpha_dash',
                Rule::unique('users', 'username')->ignore($pengguna->id),
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($pengguna->id),
            ],
            'role' => ['required', Rule::in([
                'admin', 'kasir', 'pemilik'
            ])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $pengguna->update($data);

        return response()->json([
            'message' => 'Akun berhasil diperbarui.',
            'data' => $pengguna->only([
                'id', 'name', 'username', 'email', 'role', 'status'
            ]),
        ]);
    }

    public function destroy(User $pengguna)
    {
        if (auth()->id() === $pengguna->id) {
            return response()->json([
                'message' => 'Kamu tidak bisa menghapus akun yang sedang digunakan.',
            ], 422);
        }

        if (
            $pengguna->role === 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return response()->json([
                'message' => 'Akun Admin terakhir tidak boleh dihapus.',
            ], 422);
        }

        $pengguna->delete();

        return response()->json([
            'message' => 'Akun berhasil dihapus.',
        ]);
    }
}
