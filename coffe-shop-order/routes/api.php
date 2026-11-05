
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MetodePembayaranController;

// API umum
Route::apiResource('kategori-menu', KategoriMenuController::class);
Route::apiResource('menu', MenuController::class);
Route::apiResource('meja', MejaController::class);
Route::apiResource('pelanggan', PelangganController::class);

// Pelanggan boleh memesan tanpa login
Route::post(
    'pesanan-pelanggan',
    [PesananController::class, 'storeDariPelanggan']
);

// API khusus pegawai yang sudah login
Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('pesanan', PesananController::class);

    Route::apiResource('detail-pesanan', DetailPesananController::class);
    Route::apiResource('transaksi', TransaksiController::class);
    Route::apiResource('metode-pembayaran', MetodePembayaranController::class);

});
