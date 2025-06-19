<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransportasiApiController extends Controller
{
    // GET: Menampilkan semua data transportasi
    public function index(): JsonResponse
    {
        $data = Transportasi::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    // GET: Menampilkan data berdasarkan ID
    public function show($id): JsonResponse
    {
        $data = Transportasi::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    // POST: Menyimpan data transportasi baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'jenis' => 'required|string|max:100',
            'factor_emisi' => 'required|numeric|min:0',
        ]);

        $data = Transportasi::create($request->only('kategori', 'jenis', 'factor_emisi'));

        return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan', 'data' => $data]);
    }

    // PUT: Memperbarui data transportasi berdasarkan ID
    public function update(Request $request, $id): JsonResponse
    {
        $data = Transportasi::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'kategori' => 'required|string|max:100',
            'jenis' => 'required|string|max:100',
            'factor_emisi' => 'required|numeric|min:0',
        ]);

        $data->update($request->only('kategori', 'jenis', 'factor_emisi'));

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $data]);
    }

    // DELETE: Menghapus data berdasarkan ID
    public function destroy($id): JsonResponse
    {
        $data = Transportasi::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
