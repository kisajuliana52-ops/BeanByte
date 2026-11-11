
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan BeanByte</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #292929;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #3b2418;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .kop td {
            vertical-align: middle;
        }

       .logo-container {
    text-align: center;
    width: 100%;
}

.logo {
    width: 95px;
    height: 85px;
}

        .identitas {
            text-align: center;
        }

        .identitas h1 {
            margin: 0;
            font-size: 25px;
            color: #5b3524;
            letter-spacing: 2px;
        }

        .identitas p {
            margin: 4px 0;
            font-size: 10px;
        }

        .judul {
            text-align: center;
            margin: 20px 0;
        }

        .judul h2 {
            margin: 0 0 6px;
            font-size: 16px;
        }

        .ringkasan {
            width: 100%;
            margin-bottom: 18px;
        }

        .ringkasan td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .angka {
            font-size: 15px;
            font-weight: bold;
            color: #5b3524;
            margin-top: 5px;
        }

        h3 {
            margin-top: 18px;
            margin-bottom: 8px;
            color: #5b3524;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data th {
            background: #5b3524;
            color: white;
            padding: 8px;
            border: 1px solid #5b3524;
        }

        table.data td {
            border: 1px solid #ddd;
            padding: 7px;
        }

        .kanan {
            text-align: right;
        }

        .tengah {
            text-align: center;
        }

        .ttd {
            width: 100%;
            margin-top: 35px;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .garis {
            margin-top: 65px;
            font-weight: bold;
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 9px;
            color: #777;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT BEANBYTE --}}
    @php
        $logo = public_path('foto/logo.jpeg');

        $logoData = file_exists($logo)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo))
            : null;
    @endphp

    <table class="kop">
        <tr>
            <td width="20%" class="tengah">
             <div class="logo-container">
    @if($logoData)
        <img src="{{ $logoData }}" class="logo" alt="Logo BeanByte">
    @else
        <strong>BEANBYTE</strong>
    @endif
</div>
            </td>

            <td width="80%" class="identitas">
                <h1>BEANBYTE</h1>
                <p><strong>COFFEE SHOP ORDER SYSTEM</strong></p>
                <p>Laporan Penjualan Resmi BeanByte</p>
                <p>Dokumen Laporan Pemilik</p>
            </td>
        </tr>
    </table>

    {{-- JUDUL LAPORAN --}}
    <div class="judul">
        <h2>LAPORAN PENJUALAN</h2>
        <p>
            Periode:
            {{ \Carbon\Carbon::parse($laporan['tanggal_mulai'])->format('d-m-Y') }}
            sampai
            {{ \Carbon\Carbon::parse($laporan['tanggal_selesai'])->format('d-m-Y') }}
        </p>
    </div>

    {{-- RINGKASAN --}}
    <h3>Ringkasan Penjualan</h3>

    <table class="ringkasan">
        <tr>
            <td>
                Total Pendapatan
                <div class="angka">
                    Rp {{ number_format($laporan['ringkasan']['total_pendapatan'], 0, ',', '.') }}
                </div>
            </td>

            <td>
                Jumlah Transaksi
                <div class="angka">
                    {{ $laporan['ringkasan']['jumlah_transaksi'] }}
                </div>
            </td>

            <td>
                Produk Terjual
                <div class="angka">
                    {{ $laporan['ringkasan']['total_produk_terjual'] }}
                </div>
            </td>
        </tr>
    </table>

    {{-- DETAIL TRANSAKSI --}}
    <h3>Detail Transaksi</h3>

    <table class="data">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Metode Pembayaran</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($laporan['detail_transaksi'] as $i => $trx)
                <tr>
                    <td class="tengah">{{ $i + 1 }}</td>
                    <td class="tengah">{{ $trx['id_transaksi'] }}</td>
                    <td>{{ $trx['tanggal_transaksi'] }}</td>
                    <td>{{ $trx['nama_pelanggan'] }}</td>
                    <td>{{ $trx['nama_metode'] }}</td>
                    <td class="kanan">
                        Rp {{ number_format($trx['total_bayar'], 0, ',', '.') }}
                    </td>
                    <td class="tengah">{{ $trx['status_transaksi'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="tengah">
                        Tidak ada transaksi berhasil pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PRODUK TERLARIS --}}
    <h3>Produk Terlaris</h3>

    <table class="data">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Jumlah Terjual</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($laporan['produk_terlaris'] as $i => $produk)
                <tr>
                    <td class="tengah">{{ $i + 1 }}</td>
                    <td>{{ $produk['nama_menu'] }}</td>
                    <td class="tengah">{{ $produk['jumlah_terjual'] }}</td>
                    <td class="kanan">
                        Rp {{ number_format($produk['total_pendapatan'], 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="tengah">
                        Belum ada produk terjual.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- METODE PEMBAYARAN --}}
    <h3>Ringkasan Metode Pembayaran</h3>

    <table class="data">
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th>Jumlah Transaksi</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($laporan['metode_pembayaran'] as $metode)
                <tr>
                    <td>{{ $metode['nama_metode'] }}</td>
                    <td class="tengah">{{ $metode['jumlah_transaksi'] }}</td>
                    <td class="kanan">
                        Rp {{ number_format($metode['total_pendapatan'], 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="tengah">
                        Belum ada data pembayaran.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table class="ttd">
        <tr>
            <td></td>
            <td>
                Pemilik BeanByte
                <div class="garis">
                    (................................)
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh sistem BeanByte.
    </div>

</body>
</html>
