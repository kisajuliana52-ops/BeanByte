<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return response()->json(pelanggan::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_pelanggan' => 'required|string|max:50',
        ]);

        $pelanggan = pelanggan::create($data);

        return response()->json($pelanggan, 201);
    }

    public function show($id)
    {
        return response()->json(pelanggan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = pelanggan::findOrFail($id);

        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_pelanggan' => 'required|string|max:50',
        ]);

        $pelanggan->update($data);

        return response()->json($pelanggan);
    }

    public function destroy($id)
    {
        $pelanggan = pelanggan::findOrFail($id);
        $pelanggan->delete();

        return response()->json([
            'message' => 'Pelanggan berhasil dihapus'
        ]);
    }
}