<?php

use App\Http\Controllers\AdminDataController;
use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\LaporanPemilikController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/pelanggan');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/' . Auth::user()->role);
    }

    return view('auth.login');
})->name('login');

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

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()
            ->withErrors([
                'username' => 'Username atau password salah, atau akun tidak aktif.'
            ])
            ->onlyInput('username');
    }

    $request->session()->regenerate();

    $user = Auth::user();

    if (!in_array($user->role, ['admin', 'kasir', 'pemilik', 'pelanggan'], true)) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->withErrors([
            'username' => 'Role akun tidak valid.'
        ]);
    }

    $request->session()->put([
        'name' => $user->name,
        'username' => $user->username,
        'role' => $user->role,
    ]);

    return redirect('/' . $user->role);
})->middleware('throttle:5,1');

Route::get('/pelanggan', function () {
    return view('auth.pelanggan.index');
})->name('pelanggan');


/*
|--------------------------------------------------------------------------
| HALAMAN KASIR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/kasir', function () {
        return view('auth.kasir.index');
    });

    // Mengambil data pesanan dari database
    Route::get('/kasir/data/pesanan', [PesananController::class, 'index']);

    // Mengambil data transaksi dari database
    Route::get('/kasir/data/transaksi', [TransaksiController::class, 'index']);

});


/*
|--------------------------------------------------------------------------
| HALAMAN ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Halaman utama Admin
    Route::get('/admin', function () {
        return view('auth.admin.index');
    });

    // Mengambil data pesanan dari database
    Route::get('/admin/data/pesanan', [PesananController::class, 'index']);

    // Kelola pengguna
    Route::get('/admin/pengguna', [AdminPenggunaController::class, 'index']);

    Route::post('/admin/pengguna', [AdminPenggunaController::class, 'store']);

    Route::put('/admin/pengguna/{pengguna}', [AdminPenggunaController::class, 'update']);

    Route::delete('/admin/pengguna/{pengguna}', [AdminPenggunaController::class, 'destroy']);
        // DATA UTAMA ADMIN
    Route::get('/admin/data', [AdminDataController::class, 'index']);

    // KELOLA MENU
    Route::post('/admin/data/menu', [AdminDataController::class, 'storeMenu']);
    Route::put('/admin/data/menu/{id}', [AdminDataController::class, 'updateMenu']);
    Route::delete('/admin/data/menu/{id}', [AdminDataController::class, 'destroyMenu']);

    // KELOLA KATEGORI
    Route::post('/admin/data/kategori', [AdminDataController::class, 'storeKategori']);
    Route::put('/admin/data/kategori/{id}', [AdminDataController::class, 'updateKategori']);
    Route::delete('/admin/data/kategori/{id}', [AdminDataController::class, 'destroyKategori']);

    // KELOLA STATUS PESANAN DAN TRANSAKSI
    Route::put('/admin/data/pesanan/{id}/status', [AdminDataController::class, 'updateStatusPesanan']);
    Route::put('/admin/data/transaksi/{id}/status', [AdminDataController::class, 'updateStatusTransaksi']);

    // PELANGGAN LANGGANAN
    Route::put('/admin/data/pelanggan/{id}', [AdminDataController::class, 'updatePelanggan']);

    // QR PELANGGAN
    Route::get('/admin/data/qr', [AdminDataController::class, 'dataQr']);

});

/*
|--------------------------------------------------------------------------
| HALAMAN PEMILIK
|--------------------------------------------------------------------------
*/

Route::middleware('role:pemilik')->group(function () {

    Route::get('/pemilik', function () {
        return view('auth.pemilik.index');
    });

    Route::get('/pemilik/laporan/data', [LaporanPemilikController::class, 'data']);

    Route::get('/pemilik/laporan/pdf', [LaporanPemilikController::class, 'pdf']);

    Route::get('/pemilik/produk-terlaris/pdf', [LaporanPemilikController::class, 'pdfProdukTerlaris']);

});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');

})->middleware('auth');
