<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPemilikController extends Controller
{
    /**
     * Mengambil data laporan penjualan.
     */
    private function ambilDataLaporan(Request $request)
    {
        $request->validate([
            'periode' => 'nullable|in:hari_ini,3_hari,7_hari,bulan_lalu,custom',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $sekarang = Carbon::today();
        $periode = $request->input('periode', '7_hari');

        switch ($periode) {
            case 'hari_ini':
                $mulai = $sekarang->copy();
                $selesai = $sekarang->copy();
                break;

            case '3_hari':
                $mulai = $sekarang->copy()->subDays(2);
                $selesai = $sekarang->copy();
                break;

            case '7_hari':
                $mulai = $sekarang->copy()->subDays(6);
                $selesai = $sekarang->copy();
                break;

            case 'bulan_lalu':
                $mulai = $sekarang->copy()->subMonthNoOverflow()->startOfMonth();
                $selesai = $sekarang->copy()->subMonthNoOverflow()->endOfMonth();
                break;

            case 'custom':
                if (
                    !$request->filled('tanggal_mulai') ||
                    !$request->filled('tanggal_selesai')
                ) {
                    abort(422, 'Tanggal mulai dan tanggal selesai wajib diisi.');
                }

                $mulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
                $selesai = Carbon::parse($request->tanggal_selesai)->endOfDay();
                break;

            default:
                $mulai = $sekarang->copy()->subDays(6);
                $selesai = $sekarang->copy();
                break;
        }

        // Hanya transaksi yang berhasil dihitung sebagai penjualan.
        $transaksi = Transaksi::with([
            'pesanan.pelanggan',
            'pesanan.detailPesanans.menu',
            'metodePembayaran',
        ])
            ->where('status_transaksi', 'berhasil')
            ->whereBetween('tanggal_transaksi', [
                $mulai->toDateTimeString(),
                $selesai->toDateTimeString(),
            ])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalPendapatan = $transaksi->sum('total_bayar');
        $jumlahTransaksi = $transaksi->count();

        $totalProdukTerjual = 0;
        $produk = [];

        foreach ($transaksi as $trx) {
            if (!$trx->pesanan) {
                continue;
            }

            foreach ($trx->pesanan->detailPesanans as $detail) {
                $namaMenu = $detail->menu->nama_menu ?? 'Menu tidak ditemukan';
                $jumlah = (int) $detail->jumlah;

                $totalProdukTerjual += $jumlah;

                if (!isset($produk[$namaMenu])) {
                    $produk[$namaMenu] = [
                        'nama_menu' => $namaMenu,
                        'jumlah_terjual' => 0,
                        'total_pendapatan' => 0,
                    ];
                }

                $produk[$namaMenu]['jumlah_terjual'] += $jumlah;
                $produk[$namaMenu]['total_pendapatan'] +=
                    (float) $detail->subtotal;
            }
        }

        $produkTerlaris = collect(array_values($produk))
            ->sortByDesc('jumlah_terjual')
            ->values();

        $metodePembayaran = $transaksi
            ->groupBy(function ($trx) {
                return $trx->metodePembayaran->nama_metode
                    ?? 'Tidak diketahui';
            })
            ->map(function ($items, $namaMetode) {
                return [
                    'nama_metode' => $namaMetode,
                    'jumlah_transaksi' => $items->count(),
                    'total_pendapatan' => $items->sum('total_bayar'),
                ];
            })
            ->values();

        $trenPenjualan = [];

        for (
            $tanggal = $mulai->copy()->startOfDay();
            $tanggal->lte($selesai);
            $tanggal->addDay()
        ) {
            $tanggalKey = $tanggal->format('Y-m-d');

            $transaksiHariIni = $transaksi->filter(function ($trx) use ($tanggalKey) {
                return Carbon::parse($trx->tanggal_transaksi)
                    ->format('Y-m-d') === $tanggalKey;
            });

            $trenPenjualan[] = [
                'tanggal' => $tanggalKey,
                'jumlah_transaksi' => $transaksiHariIni->count(),
                'pendapatan' => $transaksiHariIni->sum('total_bayar'),
            ];
        }

        $detailTransaksi = $transaksi->map(function ($trx) {
            return [
                'id_transaksi' => $trx->id_transaksi,
                'tanggal_transaksi' => $trx->tanggal_transaksi,
                'nama_pelanggan' => $trx->pesanan->pelanggan->nama_pelanggan
                    ?? 'Pelanggan',
                'nama_metode' => $trx->metodePembayaran->nama_metode
                    ?? 'Tidak diketahui',
                'total_bayar' => (float) $trx->total_bayar,
                'status_transaksi' => $trx->status_transaksi,
            ];
        });

        return [
            'periode' => $periode,
            'tanggal_mulai' => $mulai->toDateString(),
            'tanggal_selesai' => $selesai->toDateString(),
            'ringkasan' => [
                'total_pendapatan' => (float) $totalPendapatan,
                'jumlah_transaksi' => $jumlahTransaksi,
                'total_produk_terjual' => $totalProdukTerjual,
            ],
            'tren_penjualan' => $trenPenjualan,
            'metode_pembayaran' => $metodePembayaran,
            'produk_terlaris' => $produkTerlaris,
            'detail_transaksi' => $detailTransaksi,
        ];
    }

    /**
     * Data khusus dashboard Pemilik.
     */
    public function dashboard()
    {
        $batas = Carbon::now()->subDays(59)->startOfDay();

        $menus = DB::table('menus')
            ->leftJoin(
                'kategori_menus',
                'menus.id_kategori',
                '=',
                'kategori_menus.id_kategori'
            )
            ->select(
                'menus.id_menu',
                'menus.nama_menu',
                'menus.harga',
                'kategori_menus.nama_kategori'
            )
            ->orderBy('menus.nama_menu')
            ->get();

        $transaksi = DB::table('transaksis')
            ->join(
                'pesanans',
                'transaksis.id_pesanan',
                '=',
                'pesanans.id_pesanan'
            )
            ->leftJoin(
                'pelanggans',
                'pesanans.id_pelanggan',
                '=',
                'pelanggans.id_pelanggan'
            )
            ->leftJoin(
                'metode_pembayarans',
                'transaksis.id_metode',
                '=',
                'metode_pembayarans.id_metode'
            )
            ->leftJoin(
                'detail_pesanans',
                'pesanans.id_pesanan',
                '=',
                'detail_pesanans.id_pesanan'
            )
            ->leftJoin(
                'menus',
                'detail_pesanans.id_menu',
                '=',
                'menus.id_menu'
            )
            ->leftJoin(
                'kategori_menus',
                'menus.id_kategori',
                '=',
                'kategori_menus.id_kategori'
            )
            ->where('transaksis.status_transaksi', 'berhasil')
            ->where('transaksis.tanggal_transaksi', '>=', $batas)
            ->select(
                'transaksis.id_transaksi',
                'transaksis.id_pesanan',
                'transaksis.tanggal_transaksi',
                'transaksis.total_bayar',
                'transaksis.status_transaksi',
                'pelanggans.nama_pelanggan',
                'metode_pembayarans.nama_metode',
                'detail_pesanans.id_menu',
                'detail_pesanans.jumlah',
                'detail_pesanans.harga_satuan',
                'detail_pesanans.subtotal',
                'menus.nama_menu',
                'menus.harga as harga_menu',
                'kategori_menus.nama_kategori'
            )
            ->orderByDesc('transaksis.tanggal_transaksi')
            ->get();

        return response()->json([
            'menus' => $menus,
            'transaksi' => $transaksi,
        ]);
    }

    /**
     * Endpoint data laporan untuk dashboard.
     */
    public function data(Request $request)
    {
        return response()->json(
            $this->ambilDataLaporan($request)
        );
    }

    /**
     * Membuat PDF laporan penjualan.
     */
    public function pdf(Request $request)
    {
        $laporan = $this->ambilDataLaporan($request);

        $pdf = Pdf::loadView(
            'auth.pemilik.laporan-pdf',
            compact('laporan')
        )->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Penjualan-BeanByte.pdf');
    }

    /**
     * Membuat PDF khusus produk terlaris.
     */
    public function pdfProdukTerlaris(Request $request)
    {
        $laporan = $this->ambilDataLaporan($request);

        $produkTerlaris = $laporan['produk_terlaris'];

        $pdf = Pdf::loadView(
            'auth.pemilik.produk-terlaris-pdf',
            compact('laporan', 'produkTerlaris')
        )->setPaper('a4', 'portrait');

        return $pdf->download('Produk-Terlaris-BeanByte.pdf');
    }
}
