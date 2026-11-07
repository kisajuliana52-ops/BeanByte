<?php

namespace App\Http\Controllers;

use App\Models\meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        return response()->json(meja::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_meja' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
        ]);

        $meja = meja::create($data);

        return response()->json($meja, 201);
    }

    public function show($id)
    {
        return response()->json(meja::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $meja = meja::findOrFail($id);

        $data = $request->validate([
            'nomor_meja' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
        ]);

        $meja->update($data);

        return response()->json($meja);
    }

    public function destroy($id)
    {
        $meja = meja::findOrFail($id);
        $meja->delete();

        return response()->json([
            'message' => 'Meja berhasil dihapus'
        ]);
    }
}