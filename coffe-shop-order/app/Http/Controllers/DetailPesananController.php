<?php

namespace App\Http\Controllers;

use App\Models\Detail_Pesanan;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DetailPesananController extends Controller
{
    // Menampilkan semua detail pesanan
    public function index()
    {
        return response()->json(
            Detail_Pesanan::with(['pesanan', 'menu'])->get(),
            200
        );
    }

    // Menambahkan detail pesanan dan mengurangi stok menu
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id_pesanan',
            'id_menu' => 'required|exists:menus,id_menu',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $detail = DB::transaction(function () use ($data) {
            $menu = Menu::where('id_menu', $data['id_menu'])
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan stok mencukupi
            if ($menu->stok < $data['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => [
                        'Stok menu tidak mencukupi. Stok tersedia: '
                        . $menu->stok
                    ],
                ]);
            }

            // Kurangi stok menu
            $menu->stok -= $data['jumlah'];
            $menu->save();

            // Hitung subtotal
            $data['subtotal'] =
                $data['jumlah'] * $data['harga_satuan'];

            // Simpan detail pesanan
            $detail = Detail_Pesanan::create($data);

            // Hitung ulang total pesanan
            $this->perbaruiTotal($data['id_pesanan']);

            return $detail;
        });

        return response()->json([
            'message' => 'Detail pesanan berhasil dibuat dan stok menu diperbarui',
            'data' => $detail->load('menu'),
        ], 201);
    }

    // Menampilkan satu detail pesanan
    public function show($id)
    {
        $detail = Detail_Pesanan::with(['pesanan', 'menu'])
            ->findOrFail($id);

        return response()->json($detail, 200);
    }

    // Mengubah detail pesanan dan menyesuaikan stok
    public function update(Request $request, $id)
    {
        $detail = Detail_Pesanan::findOrFail($id);

        $data = $request->validate([
            'id_pesanan' => 'sometimes|required|exists:pesanans,id_pesanan',
            'id_menu' => 'sometimes|required|exists:menus,id_menu',
            'jumlah' => 'sometimes|required|integer|min:1',
            'harga_satuan' => 'sometimes|required|numeric|min:0',
            'catatan' => 'sometimes|nullable|string',
        ]);

        $detail = DB::transaction(function () use ($detail, $data) {
            $idPesananLama = $detail->id_pesanan;
            $idMenuLama = $detail->id_menu;
            $jumlahLama = $detail->jumlah;

            $idMenuBaru = $data['id_menu'] ?? $idMenuLama;
            $jumlahBaru = $data['jumlah'] ?? $jumlahLama;

            if ($idMenuBaru == $idMenuLama) {
                // Menu sama: sesuaikan berdasarkan selisih jumlah
                $menu = Menu::where('id_menu', $idMenuLama)
                    ->lockForUpdate()
                    ->firstOrFail();

                $selisih = $jumlahBaru - $jumlahLama;

                if ($selisih > 0 && $menu->stok < $selisih) {
                    throw ValidationException::withMessages([
                        'jumlah' => [
                            'Stok menu tidak mencukupi. Stok tersedia: '
                            . $menu->stok
                        ],
                    ]);
                }

                $menu->stok -= $selisih;
                $menu->save();
            } else {
                // Menu berubah: kembalikan stok menu lama
                $menuLama = Menu::where('id_menu', $idMenuLama)
                    ->lockForUpdate()
                    ->firstOrFail();

                $menuLama->stok += $jumlahLama;
                $menuLama->save();

                // Kurangi stok menu baru
                $menuBaru = Menu::where('id_menu', $idMenuBaru)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($menuBaru->stok < $jumlahBaru) {
                    throw ValidationException::withMessages([
                        'jumlah' => [
                            'Stok menu baru tidak mencukupi. Stok tersedia: '
                            . $menuBaru->stok
                        ],
                    ]);
                }

                $menuBaru->stok -= $jumlahBaru;
                $menuBaru->save();
            }

            $detail->fill($data);
            $detail->subtotal =
                $detail->jumlah * $detail->harga_satuan;
            $detail->save();

            $this->perbaruiTotal($idPesananLama);

            if ($detail->id_pesanan != $idPesananLama) {
                $this->perbaruiTotal($detail->id_pesanan);
            }

            return $detail->fresh(['pesanan', 'menu']);
        });

        return response()->json([
            'message' => 'Detail pesanan berhasil diperbarui dan stok disesuaikan',
            'data' => $detail,
        ], 200);
    }

    // Menghapus detail dan mengembalikan stok menu
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $detail = Detail_Pesanan::where(
                'id_detailpesanan',
                $id
            )->lockForUpdate()->firstOrFail();

            $idPesanan = $detail->id_pesanan;

            $menu = Menu::where('id_menu', $detail->id_menu)
                ->lockForUpdate()
                ->firstOrFail();

            // Kembalikan stok sesuai jumlah detail yang dihapus
            $menu->stok += $detail->jumlah;
            $menu->save();

            $detail->delete();

            $this->perbaruiTotal($idPesanan);
        });

        return response()->json([
            'message' => 'Detail pesanan berhasil dihapus dan stok dikembalikan',
        ], 200);
    }

    // Menghitung ulang total harga pesanan
    private function perbaruiTotal($idPesanan)
    {
        $pesanan = Pesanan::findOrFail($idPesanan);

        $pesanan->total_harga = $pesanan
            ->detailPesanans()
            ->sum('subtotal');

        $pesanan->save();
    }
}
