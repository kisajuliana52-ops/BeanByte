 <?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\AdminPenggunaController;


/*
|--------------------------------------------------------------------------
| LOGIN API
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');


/*
|--------------------------------------------------------------------------
| API PUBLIK PELANGGAN
|--------------------------------------------------------------------------
*/

// Halaman pelanggan dan kasir hanya memerlukan daftar menu.
Route::get('/menu', [MenuController::class, 'index']);


/*
|--------------------------------------------------------------------------
| PEMESANAN PELANGGAN TANPA LOGIN
|--------------------------------------------------------------------------
*/

Route::post(
    '/pesanan-pelanggan',
    [PesananController::class, 'storeDariPelanggan']
)->middleware('throttle:10,1');


/*
|--------------------------------------------------------------------------
| PENGELOLAAN DATA KHUSUS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'api.role:admin'])->group(function () {

    Route::apiResource('kategori-menu', KategoriMenuController::class);

    // Endpoint index tetap publik; endpoint detail dan perubahan hanya untuk admin.
    Route::apiResource('menu', MenuController::class)->except(['index']);

    Route::apiResource('meja', MejaController::class);

    // Data pelanggan memuat informasi pribadi, jadi semua endpoint perlu login admin.
    Route::apiResource('pelanggan', PelangganController::class);

    Route::apiResource('pengguna', AdminPenggunaController::class)
        ->except(['show']);

});


/*
|--------------------------------------------------------------------------
| API KHUSUS PEGAWAI
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

});

// Pesanan bisa dilihat dan diperbarui oleh admin, pemilik, atau kasir.
// Policy tetap membatasi operasi yang tidak diizinkan untuk role tertentu.
Route::middleware(['auth:sanctum', 'api.role:admin,pemilik,kasir'])->group(function () {

    // Controller tidak memiliki method store; pesanan baru dibuat dari endpoint pelanggan.
    Route::apiResource('pesanan', PesananController::class)->except(['store']);

});

// Kasir boleh melihat rincian pesanan; perubahan stok dan subtotal khusus admin.
Route::middleware(['auth:sanctum', 'api.role:admin,kasir'])->group(function () {

    Route::apiResource('detail-pesanan', DetailPesananController::class)
        ->only(['index', 'show']);

});

Route::middleware(['auth:sanctum', 'api.role:admin'])->group(function () {

    Route::apiResource('detail-pesanan', DetailPesananController::class)
        ->except(['index', 'show']);

});

// Kasir perlu membaca dan memproses transaksi; penghapusan tetap admin.
Route::middleware(['auth:sanctum', 'api.role:admin,kasir'])->group(function () {

    Route::get('/transaksi/{id}/bukti', [TransaksiController::class, 'downloadBukti'])
        ->name('api.transaksi.bukti');

    Route::apiResource('transaksi', TransaksiController::class)
        ->only(['index', 'show', 'store', 'update']);

    Route::apiResource('metode-pembayaran', MetodePembayaranController::class)
        ->only(['index', 'show']);

});

Route::middleware(['auth:sanctum', 'api.role:admin'])->group(function () {

    Route::apiResource('transaksi', TransaksiController::class)
        ->only(['destroy']);

    Route::apiResource('metode-pembayaran', MetodePembayaranController::class)
        ->except(['index', 'show']);

});
