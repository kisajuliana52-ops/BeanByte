<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        $transaksi = Transaksi::with([
            'pesanan.pelanggan',
            'pesanan.meja',
            'metodePembayaran'
        ])->get();

        return response()->json($transaksi, 200);
    }

    // Membuat transaksi pembayaran
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pesanan' => 'required|integer|exists:pesanans,id_pesanan',
            'id_metode' => 'required|integer|exists:metode_pembayarans,id_metode',
            'tanggal_transaksi' => 'nullable|date',
            'total_bayar' => 'required|numeric|min:0',
            'bukti_pembayaran' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'status_transaksi' => 'required|string|max:30',
        ]);

        $pesanan = Pesanan::findOrFail($data['id_pesanan']);

        if ((float) $data['total_bayar'] > (float) $pesanan->total_harga) {
            return response()->json([
                'message' => 'Total pembayaran melebihi total tagihan.',
                'total_tagihan' => $pesanan->total_harga,
            ], 422);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $data['bukti_pembayaran'] = $request
                ->file('bukti_pembayaran')
                ->store('bukti-pembayaran', 'public');
        } else {
            unset($data['bukti_pembayaran']);
        }

        $transaksi = DB::transaction(function () use ($data, $pesanan) {
            if (empty($data['tanggal_transaksi'])) {
                $data['tanggal_transaksi'] = now();
            }

            $transaksi = Transaksi::create($data);

            if ($data['status_transaksi'] === 'berhasil') {
                $pesanan->status = 'selesai';
                $pesanan->save();
            }

            return $transaksi;
        });

        return response()->json([
            'message' => 'Transaksi berhasil disimpan.',
            'data' => $transaksi->load([
                'pesanan.pelanggan',
                'pesanan.meja',
                'metodePembayaran'
            ]),
        ], 201);
    }

    // Menampilkan satu transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'pesanan.pelanggan',
            'pesanan.meja',
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
            'bukti_pembayaran' => [
                'sometimes',
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'status_transaksi' => 'sometimes|required|string|max:30',
        ]);

        $idPesanan = $data['id_pesanan'] ?? $transaksi->id_pesanan;
        $totalBayar = $data['total_bayar'] ?? $transaksi->total_bayar;

        $pesanan = Pesanan::findOrFail($idPesanan);

        if ((float) $totalBayar > (float) $pesanan->total_harga) {
            return response()->json([
                'message' => 'Total pembayaran melebihi total tagihan.',
                'total_tagihan' => $pesanan->total_harga,
            ], 422);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            if ($transaksi->bukti_pembayaran) {
                Storage::disk('public')->delete(
                    $transaksi->bukti_pembayaran
                );
            }

            $data['bukti_pembayaran'] = $request
                ->file('bukti_pembayaran')
                ->store('bukti-pembayaran', 'public');
        } else {
            unset($data['bukti_pembayaran']);
        }

        $transaksi->update($data);

        if (($data['status_transaksi'] ?? $transaksi->status_transaksi) === 'berhasil') {
            $pesanan->status = 'selesai';
            $pesanan->save();
        }

        return response()->json([
            'message' => 'Transaksi berhasil diperbarui.',
            'data' => $transaksi->fresh()->load([
                'pesanan.pelanggan',
                'pesanan.meja',
                'metodePembayaran'
            ]),
        ], 200);
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->bukti_pembayaran) {
            Storage::disk('public')->delete(
                $transaksi->bukti_pembayaran
            );
        }

        $transaksi->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus.',
        ], 200);
    }
}
