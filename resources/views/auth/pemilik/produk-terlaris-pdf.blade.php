```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk Terlaris BeanByte</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #292929;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #3b2418;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }

        .kop td {
            vertical-align: middle;
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
            margin: 25px 0;
        }

        .judul h2 {
            font-size: 16px;
        }

        .info {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #5b3524;
            color: white;
            padding: 10px;
            border: 1px solid #5b3524;
        }

        table.data td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .tengah {
            text-align: center;
        }

        .kanan {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 35px;
            font-size: 9px;
            color: #777;
        }
    </style>
</head>

<body>

    @php
        $logo = public_path('foto/logo.jpeg');

        $logoData = file_exists($logo)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo))
            : null;
    @endphp

    <table class="kop">
        <tr>
            <td width="20%" class="tengah">
                @if($logoData)
                    <img src="{{ $logoData }}" class="logo" alt="Logo BeanByte">
                @else
                    <strong>BEANBYTE</strong>
                @endif
            </td>

            <td width="80%" class="identitas">
                <h1>BEANBYTE</h1>
                <p><strong>COFFEE SHOP ORDER SYSTEM</strong></p>
                <p>Laporan Produk Terlaris BeanByte</p>
                <p>Dokumen Laporan Pemilik</p>
            </td>
        </tr>
    </table>

    <div class="judul">
        <h2>LAPORAN PRODUK TERLARIS</h2>

        <p>
            Periode:
            {{ \Carbon\Carbon::parse($laporan['tanggal_mulai'])->format('d-m-Y') }}
            sampai
            {{ \Carbon\Carbon::parse($laporan['tanggal_selesai'])->format('d-m-Y') }}
        </p>
    </div>

    <div class="info">
        <strong>Total Produk Terjual:</strong>
        {{ $laporan['ringkasan']['total_produk_terjual'] }} unit
        <br>

        <strong>Jumlah Jenis Produk Terjual:</strong>
        {{ $produkTerlaris->count() }} produk
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="10%">Peringkat</th>
                <th>Nama Produk</th>
                <th width="20%">Jumlah Terjual</th>
                <th width="30%">Total Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($produkTerlaris as $i => $produk)
                <tr>
                    <td class="tengah">{{ $i + 1 }}</td>

                    <td>{{ $produk['nama_menu'] }}</td>

                    <td class="tengah">
                        {{ $produk['jumlah_terjual'] }}
                    </td>

                    <td class="kanan">
                        Rp {{ number_format($produk['total_pendapatan'], 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="tengah">
                        Belum ada produk terjual pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh sistem BeanByte.
    </div>

</body>
</html>
```