<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BahanBakarApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = BahanBakar::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function show($id): JsonResponse
    {
        $data = BahanBakar::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'Bahan_bakar' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $data = BahanBakar::create([
            'kategori' => $request->kategori,
            'Bahan_bakar' => $request->Bahan_bakar,
            'factorEmisi' => $request->factorEmisi,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan', 'data' => $data]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = BahanBakar::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'kategori' => 'required|string|max:100',
            'Bahan_bakar' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $data->update([
            'kategori' => $request->kategori,
            'Bahan_bakar' => $request->Bahan_bakar,
            'factorEmisi' => $request->factorEmisi,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $data]);
    }

    public function destroy($id): JsonResponse
    {
        $data = BahanBakar::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
