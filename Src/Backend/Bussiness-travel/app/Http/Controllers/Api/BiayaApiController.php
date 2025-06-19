<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\biaya;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BiayaApiController extends Controller
{
    // Tampilkan semua data biaya
    public function index(): JsonResponse
    {
        $data = biaya::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    // Tampilkan detail berdasarkan ID
    public function show($id): JsonResponse
    {
        $data = biaya::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    // Simpan data baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'jenisKendaraan' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $data = biaya::create($request->only('kategori', 'jenisKendaraan', 'factorEmisi'));

        return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan', 'data' => $data]);
    }

    // Perbarui data berdasarkan ID
    public function update(Request $request, $id): JsonResponse
    {
        $data = biaya::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'kategori' => 'required|string|max:100',
            'jenisKendaraan' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $data->update($request->only('kategori', 'jenisKendaraan', 'factorEmisi'));

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $data]);
    }

    // Hapus data berdasarkan ID
    public function destroy($id): JsonResponse
    {
        $data = biaya::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
