```php
<?php

use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\LaporanPemilikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman utama langsung ke tampilan pelanggan
Route::get('/', function () {
    return redirect('/pelanggan');
});

// Halaman login
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/' . Auth::user()->role);
    }

    return view('auth.login');
})->name('login');

// Proses login dari database
Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = [
        'username' => trim($request->input('username')),
        'password' => $request->input('password'),
        'status' => 'aktif',
    ];

    if (!Auth::attempt(
        $credentials,
        $request->boolean('remember')
    )) {
        return back()
            ->withErrors([
                'username' => 'Username atau password salah, atau akun tidak aktif.',
            ])
            ->onlyInput('username');
    }

    // Perbarui session setelah login berhasil
    $request->session()->regenerate();

    $user = Auth::user();

    // Periksa role pengguna
    if (!in_array($user->role, [
        'admin',
        'kasir',
        'pemilik',
        'pelanggan'
    ], true)) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->withErrors([
            'username' => 'Role akun tidak valid.',
        ]);
    }

    // Simpan identitas pengguna ke session
    $request->session()->put([
        'name' => $user->name,
        'username' => $user->username,
        'role' => $user->role,
    ]);

    // Arahkan pengguna sesuai role
    return redirect('/' . $user->role);

})->middleware('throttle:5,1');

// HALAMAN PELANGGAN: PUBLIK, TANPA LOGIN
Route::get('/pelanggan', function () {
    return view('auth.pelanggan.index');
})->name('pelanggan');

// Halaman kasir: harus login sebagai kasir
Route::middleware('role:kasir')->group(function () {
    Route::get('/kasir', function () {
        return view('auth.kasir.index');
    });
});

// Halaman admin dan kelola pengguna
Route::middleware('role:admin')->group(function () {
    Route::get('/admin', function () {
        return view('auth.admin.index');
    });

    Route::get('/admin/pengguna', [
        AdminPenggunaController::class,
        'index'
    ]);

    Route::post('/admin/pengguna', [
        AdminPenggunaController::class,
        'store'
    ]);

    Route::put('/admin/pengguna/{pengguna}', [
        AdminPenggunaController::class,
        'update'
    ]);

    Route::delete('/admin/pengguna/{pengguna}', [
        AdminPenggunaController::class,
        'destroy'
    ]);
});

// Halaman pemilik dan laporan penjualan
Route::middleware('role:pemilik')->group(function () {

    Route::get('/pemilik', function () {
        return view('auth.pemilik.index');
    });

    Route::get('/pemilik/laporan/data', [
        LaporanPemilikController::class,
        'data'
    ]);

    Route::get('/pemilik/laporan/pdf', [
        LaporanPemilikController::class,
        'pdf'
    ]);
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth');