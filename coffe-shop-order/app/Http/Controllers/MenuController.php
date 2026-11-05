<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Menampilkan semua menu beserta kategorinya
    public function index()
    {
        return response()->json(
            Menu::with('kategori')->get(),
            200
        );
    }

    // Menambahkan menu baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori_menus,id_kategori',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $menu = Menu::create($data);

        return response()->json($menu, 201);
    }

    // Menampilkan satu menu
    public function show($id)
    {
        return response()->json(
            Menu::with('kategori')->findOrFail($id),
            200
        );
    }

    // Memperbarui menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'id_kategori' => 'sometimes|required|exists:kategori_menus,id_kategori',
            'nama_menu' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|numeric|min:0',
            'gambar' => 'sometimes|nullable|string|max:255',
            'stok' => 'sometimes|required|integer|min:0',
        ]);

        $menu->update($data);

        return response()->json(
            $menu->load('kategori'),
            200
        );
    }

    // Menghapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus'
        ], 200);
    }
}
