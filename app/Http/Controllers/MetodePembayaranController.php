<?php

namespace App\Http\Controllers;

use App\Models\metode_pembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        return response()->json(metode_pembayaran::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_metode' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $metode = metode_pembayaran::create($data);

        return response()->json($metode, 201);
    }

    public function show($id)
    {
        return response()->json(metode_pembayaran::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $metode = metode_pembayaran::findOrFail($id);

        $data = $request->validate([
            'nama_metode' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $metode->update($data);

        return response()->json($metode);
    }

    public function destroy($id)
    {
        $metode = metode_pembayaran::findOrFail($id);
        $metode->delete();

        return response()->json([
            'message' => 'Metode pembayaran berhasil dihapus'
        ]);
    }
}