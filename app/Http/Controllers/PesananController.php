<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Detail_Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    // Menampilkan semua pesanan khusus pegawai
    public function index()
{
    return response()->json(
        Pesanan::with([
            'pelanggan',
            'meja',
            'detailPesanans.menu',
            'transaksi'
        ])->get()
    );
}

    // Membuat pesanan dari halaman pelanggan tanpa login
    public function storeDariPelanggan(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'id_meja' => 'required|integer|exists:mejas,id_meja',
            'items' => 'required|array|min:1',
            'items.*.id_menu' => 'required|integer|distinct|exists:menus,id_menu',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.catatan' => 'nullable|string',
        ]);

        $pesanan = DB::transaction(function () use ($data) {

            $pelanggan = Pelanggan::where(
                'nama_pelanggan',
                $data['nama_pelanggan']
            )->first();

            if (!$pelanggan) {
                $pelanggan = Pelanggan::create([
                    'nama_pelanggan' => $data['nama_pelanggan'],
                    'no_hp' => '0000000000',
                    'alamat' => null,
                    'jenis_pelanggan' => 'non langganan',
                ]);
            }

            $meja = Meja::where(
                'id_meja',
                $data['id_meja']
            )->lockForUpdate()->first();

            if (!$meja) {
                throw ValidationException::withMessages([
                    'id_meja' => ['Meja tidak ditemukan.'],
                ]);
            }

            $statusMeja = strtolower(trim((string) $meja->status));

            if ($statusMeja !== 'tersedia') {
                throw ValidationException::withMessages([
                    'id_meja' => [
                        'Meja sedang digunakan. Silakan hubungi kasir.',
                    ],
                ]);
            }

            $pesanan = Pesanan::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_meja' => $meja->id_meja,
                'tanggal_pesanan' => now(),
                'total_harga' => 0,
                'status' => 'menunggu',
                'stok' => 0,
            ]);

            $total = 0;
            $jumlahSemuaMenu = 0;

            foreach ($data['items'] as $item) {

                $menu = Menu::where(
                    'id_menu',
                    $item['id_menu']
                )->lockForUpdate()->first();

                if (!$menu) {
                    throw ValidationException::withMessages([
                        'items' => ['Menu tidak ditemukan.'],
                    ]);
                }

                $jumlah = (int) $item['jumlah'];

                if ($menu->stok < $jumlah) {
                    throw ValidationException::withMessages([
                        'items' => [
                            'Stok ' . $menu->nama_menu .
                            ' tidak cukup. Stok tersedia: ' .
                            $menu->stok,
                        ],
                    ]);
                }

                $subtotal = $jumlah * $menu->harga;

                Detail_Pesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu' => $menu->id_menu,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $menu->harga,
                    'subtotal' => $subtotal,
                    'catatan' => $item['catatan'] ?? null,
                ]);

                $menu->stok -= $jumlah;
                $menu->save();

                $total += $subtotal;
                $jumlahSemuaMenu += $jumlah;
            }

            if ($jumlahSemuaMenu > 2) {
                $total -= round($total * 0.15);
            }

            $pesanan->total_harga = $total;
            $pesanan->save();

            $meja->status = 'terisi';
            $meja->save();

            return $pesanan->load([
                'pelanggan',
                'meja',
                'detailPesanans.menu',
                'transaksi',
            ]);
        });

        return response()->json([
            'message' => 'Pesanan berhasil disimpan dan stok menu diperbarui.',
            'data' => $pesanan,
        ], 201);
    }

    // Menampilkan satu pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pelanggan',
            'meja',
            'detailPesanans.menu',
            'transaksi',
        ])->find($id);

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        $this->authorize('view', $pesanan);

        return response()->json($pesanan, 200);
    }

    // Memperbarui pesanan
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        $this->authorize('update', $pesanan);

        $data = $request->validate([
            'id_pelanggan' => 'sometimes|required|exists:pelanggans,id_pelanggan',
            'id_meja' => 'sometimes|required|exists:mejas,id_meja',
            'tanggal_pesanan' => 'sometimes|nullable|date',
            'total_harga' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|max:30',
            'stok' => 'sometimes|integer|min:0',
        ]);

        $pesanan->update($data);

        return response()->json([
            'message' => 'Pesanan berhasil diperbarui.',
            'data' => $pesanan,
        ], 200);
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        $this->authorize('delete', $pesanan);

        $pesanan->delete();

        return response()->json([
            'message' => 'Pesanan berhasil dihapus.',
        ], 200);
    }
}
