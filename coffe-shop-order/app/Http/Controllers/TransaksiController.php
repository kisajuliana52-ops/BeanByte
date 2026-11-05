<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        $transaksi = Transaksi::with([
            'pesanan',
            'metodePembayaran'
        ])->get();

        return response()->json($transaksi, 200);
    }

    // Membuat transaksi pembayaran
    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $data = $request->validate([
            'id_pesanan' => 'required|integer|exists:pesanans,id_pesanan',
            'id_metode' => 'required|integer|exists:metode_pembayarans,id_metode',
            'tanggal_transaksi' => 'nullable|date',
            'total_bayar' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|string|max:255',
            'status_transaksi' => 'required|string|max:30',
        ]);

        // Memastikan pesanan tersedia
        $pesanan = Pesanan::findOrFail($data['id_pesanan']);

        // Memastikan pembayaran tidak melebihi tagihan
        if ((float) $data['total_bayar'] > (float) $pesanan->total_harga) {
            return response()->json([
                'message' => 'Total pembayaran melebihi total tagihan.',
                'total_tagihan' => $pesanan->total_harga,
            ], 422);
        }

        // Menyimpan transaksi
        $transaksi = DB::transaction(function () use ($data, $pesanan) {
            if (empty($data['tanggal_transaksi'])) {
                $data['tanggal_transaksi'] = now();
            }

            $transaksi = Transaksi::create($data);

            // Jika pembayaran berhasil, pesanan menjadi selesai
            if ($data['status_transaksi'] === 'berhasil') {
                $pesanan->status = 'selesai';
                $pesanan->save();
            }

            return $transaksi;
        });

        return response()->json([
            'message' => 'Transaksi berhasil disimpan.',
            'data' => $transaksi->load([
                'pesanan',
                'metodePembayaran'
            ]),
        ], 201);
    }

    // Menampilkan satu transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'pesanan',
            'metodePembayaran'
        ])->findOrFail($id);

        return response()->json($transaksi, 200);
    }

    // Memperbarui transaksi
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $data = $request->validate([
            'id_pesanan' => 'sometimes|required|integer|exists:pesanans,id_pesanan',
            'id_metode' => 'sometimes|required|integer|exists:metode_pembayarans,id_metode',
            'tanggal_transaksi' => 'sometimes|nullable|date',
            'total_bayar' => 'sometimes|required|numeric|min:0',
            'bukti_pembayaran' => 'sometimes|nullable|string|max:255',
            'status_transaksi' => 'sometimes|required|string|max:30',
        ]);

        // Jika total pembayaran diubah, periksa tagihan pesanan
        $idPesanan = $data['id_pesanan'] ?? $transaksi->id_pesanan;
        $totalBayar = $data['total_bayar'] ?? $transaksi->total_bayar;

        $pesanan = Pesanan::findOrFail($idPesanan);

        if ((float) $totalBayar > (float) $pesanan->total_harga) {
            return response()->json([
                'message' => 'Total pembayaran melebihi total tagihan.',
                'total_tagihan' => $pesanan->total_harga,
            ], 422);
        }

        $transaksi->update($data);

        // Perbarui status pesanan jika pembayaran berhasil
        if (($data['status_transaksi'] ?? $transaksi->status_transaksi) === 'berhasil') {
            $pesanan->status = 'selesai';
            $pesanan->save();
        }

        return response()->json([
            'message' => 'Transaksi berhasil diperbarui.',
            'data' => $transaksi->fresh()->load([
                'pesanan',
                'metodePembayaran'
            ]),
        ], 200);
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus.',
        ], 200);
    }
}
