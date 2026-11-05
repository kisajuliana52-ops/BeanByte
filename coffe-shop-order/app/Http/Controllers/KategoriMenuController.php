<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori_Menu;

class KategoriMenuController extends Controller
{
    // Menampilkan semua kategori menu
    public function index()
    {
        $kategori = Kategori_Menu::all();

        return response()->json($kategori, 200);
    }

    // Menyimpan kategori menu baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $kategori = Kategori_Menu::create($data);

        return response()->json($kategori, 201);
    }

    // Menampilkan satu kategori berdasarkan ID
    public function show(string $id)
    {
        $kategori = Kategori_Menu::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori menu tidak ditemukan'
            ], 404);
        }

        return response()->json($kategori, 200);
    }

    // Memperbarui kategori menu
    public function update(Request $request, string $id)
    {
        $kategori = Kategori_Menu::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori menu tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'nama_kategori' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|nullable|string|max:255',
        ]);

        $kategori->update($data);

        return response()->json($kategori, 200);
    }

    // Menghapus kategori menu
    public function destroy(string $id)
    {
        $kategori = Kategori_Menu::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori menu tidak ditemukan'
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'message' => 'Kategori menu berhasil dihapus'
        ], 200);
    }
}
