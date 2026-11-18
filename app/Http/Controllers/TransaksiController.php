<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    // Menampilkan transaksi dan memfilter berdasarkan metode pembayaran
    public function index(Request $request)
    {
        $filter = $request->validate([
            'id_metode' => 'nullable|integer|in:1,2',
        ]);

        $query = Transaksi::with([
            'pesanan.pelanggan',
            'pesanan.meja',
            'metodePembayaran'
        ]);

        // Filter Tunai atau QRIS
        if (!empty($filter['id_metode'])) {
            $query->where('id_metode', $filter['id_metode']);
        }

        $transaksi = $query->get()->map(
            fn (Transaksi $item): Transaksi => $this->withBuktiUrl($item)
        );

        return response()->json($transaksi, 200);
    }

    // Membuat transaksi pembayaran
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pesanan' => 'required|integer|exists:pesanans,id_pesanan',
            'id_metode' => 'required|integer|in:1,2|exists:metode_pembayarans,id_metode',
            'tanggal_transaksi' => 'nullable|date',
            'total_bayar' => 'required|numeric|decimal:0,2|min:0',
            'bukti_pembayaran' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'status_transaksi' => 'required|in:pending,berhasil,dibatalkan',
        ]);

        $buktiBaru = null;

        try {
            $transaksi = DB::transaction(function () use ($data, $request, &$buktiBaru) {
                $pesanan = Pesanan::where('id_pesanan', $data['id_pesanan'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if (Transaksi::where('id_pesanan', $pesanan->id_pesanan)->exists()) {
                    throw ValidationException::withMessages([
                        'id_pesanan' => ['Transaksi untuk pesanan ini sudah ada.'],
                    ]);
                }

                $totalTagihan = number_format((float) $pesanan->total_harga, 2, '.', '');
                $totalBayar = number_format((float) $data['total_bayar'], 2, '.', '');

                if (
                    (float) $totalBayar > (float) $totalTagihan ||
                    ($data['status_transaksi'] === 'berhasil' && $totalBayar !== $totalTagihan)
                ) {
                    throw ValidationException::withMessages([
                        'total_bayar' => ['Nominal pembayaran berhasil harus sesuai total tagihan.'],
                    ]);
                }

                $data['total_bayar'] = $totalBayar;

                if ($request->hasFile('bukti_pembayaran')) {
                    $pathPrivat = $request
                        ->file('bukti_pembayaran')
                        ->store('bukti-pembayaran', 'local');

                    if (!$pathPrivat) {
                        throw new \RuntimeException('Bukti pembayaran gagal disimpan.');
                    }

                    $buktiBaru = 'private/' . $pathPrivat;
                    $data['bukti_pembayaran'] = $buktiBaru;
                } else {
                    unset($data['bukti_pembayaran']);
                }

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
        } catch (\Throwable $exception) {
            if ($buktiBaru) {
                $this->deleteBukti($buktiBaru);
            }

            throw $exception;
        }

        return response()->json([
            'message' => 'Transaksi berhasil disimpan.',
            'data' => $this->withBuktiUrl($transaksi->load([
                'pesanan.pelanggan',
                'pesanan.meja',
                'metodePembayaran'
            ])),
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

        return response()->json($this->withBuktiUrl($transaksi), 200);
    }

    // Memperbarui transaksi
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $data = $request->validate([
            'id_metode' => 'sometimes|required|integer|in:1,2|exists:metode_pembayarans,id_metode',
            'tanggal_transaksi' => 'sometimes|nullable|date',
            'total_bayar' => 'sometimes|required|numeric|decimal:0,2|min:0',
            'bukti_pembayaran' => [
                'sometimes',
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'status_transaksi' => 'sometimes|required|in:pending,berhasil,dibatalkan',
        ]);

        $idPesanan = $transaksi->id_pesanan;
        $totalBayar = $data['total_bayar'] ?? $transaksi->total_bayar;

        $pesanan = Pesanan::findOrFail($idPesanan);

        $totalTagihan = number_format((float) $pesanan->total_harga, 2, '.', '');
        $totalBayar = number_format((float) $totalBayar, 2, '.', '');
        $statusTransaksi = $data['status_transaksi'] ?? $transaksi->status_transaksi;

        if (
            (float) $totalBayar > (float) $totalTagihan ||
            ($statusTransaksi === 'berhasil' && $totalBayar !== $totalTagihan)
        ) {
            return response()->json([
                'message' => 'Nominal pembayaran berhasil harus sesuai total tagihan.',
                'total_tagihan' => $pesanan->total_harga,
            ], 422);
        }

        if (array_key_exists('total_bayar', $data)) {
            $data['total_bayar'] = $totalBayar;
        }

        $buktiLama = $transaksi->bukti_pembayaran;
        $buktiBaru = null;

        if ($request->hasFile('bukti_pembayaran')) {
            $pathPrivat = $request
                ->file('bukti_pembayaran')
                ->store('bukti-pembayaran', 'local');

            if (!$pathPrivat) {
                throw new \RuntimeException('Bukti pembayaran gagal disimpan.');
            }

            $buktiBaru = 'private/' . $pathPrivat;
            $data['bukti_pembayaran'] = $buktiBaru;
        } else {
            unset($data['bukti_pembayaran']);
        }

        try {
            $transaksi->update($data);
        } catch (\Throwable $exception) {
            if ($buktiBaru) {
                $this->deleteBukti($buktiBaru);
            }

            throw $exception;
        }

        if ($buktiBaru && $buktiLama) {
            $this->deleteBukti($buktiLama);
        }

        if (($data['status_transaksi'] ?? $transaksi->status_transaksi) === 'berhasil') {
            $pesanan->status = 'selesai';
            $pesanan->save();
        }

        return response()->json([
            'message' => 'Transaksi berhasil diperbarui.',
            'data' => $this->withBuktiUrl($transaksi->fresh()->load([
                'pesanan.pelanggan',
                'pesanan.meja',
                'metodePembayaran'
            ])),
        ], 200);
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $bukti = $transaksi->bukti_pembayaran;

        $transaksi->delete();

        if ($bukti) {
            $this->deleteBukti($bukti);
        }

        return response()->json([
            'message' => 'Transaksi berhasil dihapus.',
        ], 200);
    }

    public function downloadBukti($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $lokasi = $this->lokasiBukti($transaksi->bukti_pembayaran);

        if (!$lokasi || !Storage::disk($lokasi['disk'])->exists($lokasi['path'])) {
            return response()->json([
                'message' => 'Bukti pembayaran tidak ditemukan.',
            ], 404);
        }

        return Storage::disk($lokasi['disk'])->download(
            $lokasi['path'],
            basename($lokasi['path'])
        );
    }

    private function withBuktiUrl(Transaksi $transaksi): Transaksi
    {
        $transaksi->setAttribute(
            'bukti_url',
            $transaksi->bukti_pembayaran
                ? route('api.transaksi.bukti', ['id' => $transaksi->id_transaksi])
                : null
        );

        return $transaksi;
    }

    private function deleteBukti(?string $storedPath): void
    {
        $lokasi = $this->lokasiBukti($storedPath);

        if ($lokasi) {
            Storage::disk($lokasi['disk'])->delete($lokasi['path']);
        }
    }

    private function lokasiBukti(?string $storedPath): ?array
    {
        if (!$storedPath) {
            return null;
        }

        $privat = str_starts_with($storedPath, 'private/');
        $path = $privat ? substr($storedPath, strlen('private/')) : $storedPath;

        if (
            !str_starts_with($path, 'bukti-pembayaran/') ||
            str_contains($path, '..') ||
            str_contains($path, '\\')
        ) {
            return null;
        }

        return [
            'disk' => $privat ? 'local' : 'public',
            'path' => $path,
        ];
    }
}
