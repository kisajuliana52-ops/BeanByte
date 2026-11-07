<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // LOGIN PEGAWAI
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data login tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Mencari akun menggunakan Eloquent (parameter binding)
        $username = $request->input('username');

        $user = User::where('username', $username)->first();

        // Memeriksa username dan password
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        // Membatasi login hanya untuk pegawai
        if (!in_array(strtolower($user->role), [
            'admin',
            'pemilik',
            'kasir'
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak memiliki akses pegawai.',
            ], 403);
        }

        // Membuat token autentikasi
        $token = $user->createToken('beanbyte-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
        ], 200);
    }

    // LOGOUT PEGAWAI
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ], 200);
    }
}
