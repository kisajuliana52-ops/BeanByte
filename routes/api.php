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

Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| API UMUM
|--------------------------------------------------------------------------
*/

// Kategori Menu
Route::apiResource('kategori-menu', KategoriMenuController::class);

// Menu
Route::apiResource('menu', MenuController::class);

// Meja
Route::apiResource('meja', MejaController::class);

// Pelanggan
Route::apiResource('pelanggan', PelangganController::class);


/*
|--------------------------------------------------------------------------
| PEMESANAN PELANGGAN TANPA LOGIN
|--------------------------------------------------------------------------
*/

Route::post(
    '/pesanan-pelanggan',
    [PesananController::class, 'storeDariPelanggan']
);


/*
|--------------------------------------------------------------------------
| API KHUSUS PEGAWAI
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Kelola Pengguna
    Route::apiResource('pengguna', AdminPenggunaController::class);

    // Kelola Pesanan
    Route::apiResource('pesanan', PesananController::class);

    // Detail Pesanan
    Route::apiResource('detail-pesanan', DetailPesananController::class);

    // Transaksi
    Route::apiResource('transaksi', TransaksiController::class);

    // Metode Pembayaran
    Route::apiResource('metode-pembayaran', MetodePembayaranController::class);

});