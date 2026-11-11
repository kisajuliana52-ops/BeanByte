<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminDataController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA UTAMA ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kategori = DB::table('kategori_menus')
            ->orderBy('id_kategori')
            ->get();

        $menu = DB::table('menus')
            ->join('kategori_menus', 'menus.id_kategori', '=', 'kategori_menus.id_kategori')
            ->select(
                'menus.*',
                'kategori_menus.nama_kategori'
            )
            ->orderBy('menus.id_menu')
            ->get();

        $pelanggan = DB::table('pelanggans')
            ->orderByDesc('id_pelanggan')
            ->get();

        $meja = DB::table('mejas')
            ->orderBy('id_meja')
            ->get();

        $pesanan = DB::table('pesanans')
            ->join('pelanggans', 'pesanans.id_pelanggan', '=', 'pelanggans.id_pelanggan')
            ->join('mejas', 'pesanans.id_meja', '=', 'mejas.id_meja')
            ->select(
                'pesanans.*',
                'pelanggans.nama_pelanggan',
                'pelanggans.no_hp',
                'pelanggans.jenis_pelanggan',
                'mejas.nomor_meja'
            )
            ->orderByDesc('pesanans.id_pesanan')
            ->get();

        $detailPesanan = DB::table('detail_pesanans')
            ->join('menus', 'detail_pesanans.id_menu', '=', 'menus.id_menu')
            ->select(
                'detail_pesanans.*',
                'menus.nama_menu',
                'menus.gambar'
            )
            ->get();

        $transaksi = DB::table('transaksis')
            ->join('pesanans', 'transaksis.id_pesanan', '=', 'pesanans.id_pesanan')
            ->join('pelanggans', 'pesanans.id_pelanggan', '=', 'pelanggans.id_pelanggan')
            ->join('metode_pembayarans', 'transaksis.id_metode', '=', 'metode_pembayarans.id_metode')
            ->select(
                'transaksis.*',
                'pelanggans.nama_pelanggan',
                'metode_pembayarans.nama_metode'
            )
            ->orderByDesc('transaksis.id_transaksi')
            ->get();

        $pengguna = DB::table('users')
            ->select(
                'id',
                'name',
                'username',
                'email',
                'role',
                'status',
                'id_pelanggan'
            )
            ->orderBy('id')
            ->get();

        return response()->json([
            'kategori' => $kategori,
            'menu' => $menu,
            'pelanggan' => $pelanggan,
            'meja' => $meja,
            'pesanan' => $pesanan,
            'detail_pesanan' => $detailPesanan,
            'transaksi' => $transaksi,
            'pengguna' => $pengguna,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH MENU
    |--------------------------------------------------------------------------
    */

    public function storeMenu(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori_menus,id_kategori',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $id = DB::table('menus')->insertGetId([
            ...$data,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Menu berhasil ditambahkan.',
            'data' => DB::table('menus')->where('id_menu', $id)->first(),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT MENU
    |--------------------------------------------------------------------------
    */

    public function updateMenu(Request $request, $id)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori_menus,id_kategori',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $ada = DB::table('menus')->where('id_menu', $id)->exists();

        if (!$ada) {
            return response()->json([
                'message' => 'Menu tidak ditemukan.'
            ], 404);
        }

        DB::table('menus')
            ->where('id_menu', $id)
            ->update([
                ...$data,
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Menu berhasil diperbarui.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS MENU
    |--------------------------------------------------------------------------
    */

    public function destroyMenu($id)
    {
        $dipakai = DB::table('detail_pesanans')
            ->where('id_menu', $id)
            ->exists();

        if ($dipakai) {
            return response()->json([
                'message' => 'Menu sudah digunakan dalam pesanan sehingga tidak bisa dihapus.'
            ], 422);
        }

        $hapus = DB::table('menus')
            ->where('id_menu', $id)
            ->delete();

        if (!$hapus) {
            return response()->json([
                'message' => 'Menu tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'message' => 'Menu berhasil dihapus.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH KATEGORI
    |--------------------------------------------------------------------------
    */

    public function storeKategori(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $id = DB::table('kategori_menus')->insertGetId([
            ...$data,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => DB::table('kategori_menus')
                ->where('id_kategori', $id)
                ->first(),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT KATEGORI
    |--------------------------------------------------------------------------
    */

    public function updateKategori(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $ada = DB::table('kategori_menus')
            ->where('id_kategori', $id)
            ->exists();

        if (!$ada) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        DB::table('kategori_menus')
            ->where('id_kategori', $id)
            ->update([
                ...$data,
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS KATEGORI
    |--------------------------------------------------------------------------
    */

    public function destroyKategori($id)
    {
        $dipakai = DB::table('menus')
            ->where('id_kategori', $id)
            ->exists();

        if ($dipakai) {
            return response()->json([
                'message' => 'Kategori masih digunakan oleh menu.'
            ], 422);
        }

        $hapus = DB::table('kategori_menus')
            ->where('id_kategori', $id)
            ->delete();

        if (!$hapus) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'message' => 'Kategori berhasil dihapus.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UBAH STATUS PESANAN
    |--------------------------------------------------------------------------
    */

    public function updateStatusPesanan(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $pesanan = DB::table('pesanans')
            ->where('id_pesanan', $id)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan.'
            ], 404);
        }

        DB::table('pesanans')
            ->where('id_pesanan', $id)
            ->update([
                'status' => $data['status'],
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UBAH STATUS TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function updateStatusTransaksi(Request $request, $id)
    {
        $data = $request->validate([
            'status_transaksi' => 'required|in:pending,berhasil,dibatalkan',
        ]);

        $ada = DB::table('transaksis')
            ->where('id_transaksi', $id)
            ->exists();

        if (!$ada) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        DB::table('transaksis')
            ->where('id_transaksi', $id)
            ->update([
                'status_transaksi' => $data['status_transaksi'],
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Status transaksi berhasil diperbarui.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UBAH STATUS LANGGANAN PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function updatePelanggan(Request $request, $id)
    {
        $data = $request->validate([
            'jenis_pelanggan' => 'required|in:langganan,non langganan',
        ]);

        $ada = DB::table('pelanggans')
            ->where('id_pelanggan', $id)
            ->exists();

        if (!$ada) {
            return response()->json([
                'message' => 'Pelanggan tidak ditemukan.'
            ], 404);
        }

        DB::table('pelanggans')
            ->where('id_pelanggan', $id)
            ->update([
                'jenis_pelanggan' => $data['jenis_pelanggan'],
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Data pelanggan berhasil diperbarui.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DATA QR MEJA
    |--------------------------------------------------------------------------
    */

    public function dataQr()
    {
        $meja = DB::table('mejas')
            ->select(
                'id_meja',
                'nomor_meja',
                'kapasitas',
                'status'
            )
            ->orderBy('id_meja')
            ->get();

        return response()->json($meja);
    }
}
