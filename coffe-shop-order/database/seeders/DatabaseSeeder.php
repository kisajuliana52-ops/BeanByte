<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $waktu = now();

        // 1. KATEGORI MENU
        DB::table('kategori_menus')->updateOrInsert(
            ['id_kategori' => 1],
            [
                'nama_kategori' => 'Makanan',
                'deskripsi' => 'Menu makanan BeanByte',
                'created_at' => $waktu,
                'updated_at' => $waktu,
            ]
        );

        DB::table('kategori_menus')->updateOrInsert(
            ['id_kategori' => 2],
            [
                'nama_kategori' => 'Minuman',
                'deskripsi' => 'Menu minuman BeanByte',
                'created_at' => $waktu,
                'updated_at' => $waktu,
            ]
        );

        // 2. MEJA
        $mejas = [
            [
                'id_meja' => 1,
                'nomor_meja' => 'M01',
                'kapasitas' => 2,
                'status' => 'tersedia',
            ],
            [
                'id_meja' => 2,
                'nomor_meja' => 'M02',
                'kapasitas' => 4,
                'status' => 'tersedia',
            ],
            [
                'id_meja' => 3,
                'nomor_meja' => 'M03',
                'kapasitas' => 4,
                'status' => 'tersedia',
            ],
        ];

        foreach ($mejas as $meja) {
            DB::table('mejas')->updateOrInsert(
                ['id_meja' => $meja['id_meja']],
                array_merge($meja, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        // 3. MENU
        $menus = [
            [
                'id_menu' => 1,
                'id_kategori' => 1,
                'nama_menu' => 'Nasi Goreng',
                'harga' => 22000,
                'gambar' => 'nasi.jpg',
                'stok' => 20,
            ],
            [
                'id_menu' => 2,
                'id_kategori' => 1,
                'nama_menu' => 'Spaghetti',
                'harga' => 22000,
                'gambar' => 'spaghetti.jpg',
                'stok' => 15,
            ],
            [
                'id_menu' => 3,
                'id_kategori' => 2,
                'nama_menu' => 'Matcha',
                'harga' => 22000,
                'gambar' => 'matcha.jpg',
                'stok' => 30,
            ],
            [
                'id_menu' => 4,
                'id_kategori' => 2,
                'nama_menu' => 'Jus Strawberry',
                'harga' => 18000,
                'gambar' => 'jus.jpg',
                'stok' => 10,
            ],
        ];

        foreach ($menus as $menu) {
            DB::table('menus')->updateOrInsert(
                ['id_menu' => $menu['id_menu']],
                array_merge($menu, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        // 4. PELANGGAN
        $pelanggans = [
            [
                'id_pelanggan' => 1,
                'nama_pelanggan' => 'Andi',
                'no_hp' => '081234567801',
                'alamat' => 'Bandung',
                'jenis_pelanggan' => 'langganan',
            ],
            [
                'id_pelanggan' => 2,
                'nama_pelanggan' => 'Siti',
                'no_hp' => '081234567802',
                'alamat' => 'Ciwidey',
                'jenis_pelanggan' => 'non langganan',
            ],
            [
                'id_pelanggan' => 3,
                'nama_pelanggan' => 'Budi',
                'no_hp' => '081234567803',
                'alamat' => 'Bandung',
                'jenis_pelanggan' => 'langganan',
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            DB::table('pelanggans')->updateOrInsert(
                ['id_pelanggan' => $pelanggan['id_pelanggan']],
                array_merge($pelanggan, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        // 5. PESANAN
        $pesanans = [
            [
                'id_pesanan' => 1,
                'id_pelanggan' => 1,
                'id_meja' => 1,
                'tanggal_pesanan' => $waktu,
                'total_harga' => 44000,
                'status' => 'menunggu',
                'stok' => 0,
            ],
            [
                'id_pesanan' => 2,
                'id_pelanggan' => 2,
                'id_meja' => 2,
                'tanggal_pesanan' => $waktu,
                'total_harga' => 40000,
                'status' => 'diproses',
                'stok' => 0,
            ],
            [
                'id_pesanan' => 3,
                'id_pelanggan' => 3,
                'id_meja' => 3,
                'tanggal_pesanan' => $waktu,
                'total_harga' => 22000,
                'status' => 'selesai',
                'stok' => 0,
            ],
        ];

        foreach ($pesanans as $pesanan) {
            DB::table('pesanans')->updateOrInsert(
                ['id_pesanan' => $pesanan['id_pesanan']],
                array_merge($pesanan, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        // 6. DETAIL PESANAN
        $details = [
            [
                'id_detailpesanan' => 1,
                'id_pesanan' => 1,
                'id_menu' => 1,
                'jumlah' => 1,
                'harga_satuan' => 22000,
                'subtotal' => 22000,
                'catatan' => null,
            ],
            [
                'id_detailpesanan' => 2,
                'id_pesanan' => 1,
                'id_menu' => 3,
                'jumlah' => 1,
                'harga_satuan' => 22000,
                'subtotal' => 22000,
                'catatan' => 'Gula normal',
            ],
            [
                'id_detailpesanan' => 3,
                'id_pesanan' => 2,
                'id_menu' => 2,
                'jumlah' => 1,
                'harga_satuan' => 22000,
                'subtotal' => 22000,
                'catatan' => null,
            ],
            [
                'id_detailpesanan' => 4,
                'id_pesanan' => 2,
                'id_menu' => 4,
                'jumlah' => 1,
                'harga_satuan' => 18000,
                'subtotal' => 18000,
                'catatan' => null,
            ],
            [
                'id_detailpesanan' => 5,
                'id_pesanan' => 3,
                'id_menu' => 3,
                'jumlah' => 1,
                'harga_satuan' => 22000,
                'subtotal' => 22000,
                'catatan' => null,
            ],
        ];

        foreach ($details as $detail) {
            DB::table('detail_pesanans')->updateOrInsert(
                ['id_detailpesanan' => $detail['id_detailpesanan']],
                array_merge($detail, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        // 7. METODE PEMBAYARAN
        $metodes = [
            [
                'id_metode' => 1,
                'nama_metode' => 'Tunai',
                'keterangan' => 'Pembayaran langsung di kasir',
            ],
            [
                'id_metode' => 2,
                'nama_metode' => 'QRIS',
                'keterangan' => 'Pembayaran menggunakan QRIS',
            ],
            [
                'id_metode' => 3,
                'nama_metode' => 'Transfer Bank',
                'keterangan' => 'Pembayaran melalui transfer bank',
            ],
        ];

        foreach ($metodes as $metode) {
            DB::table('metode_pembayarans')->updateOrInsert(
                ['id_metode' => $metode['id_metode']],
                array_merge($metode, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        // 8. TRANSAKSI
        $transaksis = [
            [
                'id_transaksi' => 1,
                'id_pesanan' => 1,
                'id_metode' => 1,
                'tanggal_transaksi' => $waktu,
                'total_bayar' => 44000,
                'bukti_pembayaran' => null,
                'status_transaksi' => 'pending',
            ],
            [
                'id_transaksi' => 2,
                'id_pesanan' => 2,
                'id_metode' => 2,
                'tanggal_transaksi' => $waktu,
                'total_bayar' => 40000,
                'bukti_pembayaran' => null,
                'status_transaksi' => 'berhasil',
            ],
            [
                'id_transaksi' => 3,
                'id_pesanan' => 3,
                'id_metode' => 3,
                'tanggal_transaksi' => $waktu,
                'total_bayar' => 22000,
                'bukti_pembayaran' => null,
                'status_transaksi' => 'pending',
            ],
        ];

        foreach ($transaksis as $transaksi) {
            DB::table('transaksis')->updateOrInsert(
                ['id_transaksi' => $transaksi['id_transaksi']],
                array_merge($transaksi, [
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ])
            );
        }

        $this->command->info(
            'Seeder BeanByte berhasil dijalankan!'
        );
    }
}
