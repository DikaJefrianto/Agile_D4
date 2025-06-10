<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Menampilkan daftar perusahaan
     */
    public function index()
    {
        $perusahaans = Perusahaan::all();
        return response()->json($perusahaans);
    }

    /**
     * Menyimpan data perusahaan baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:perusahaans',
            'email' => 'required|email|unique:perusahaans',
            'password' => 'required|string|min:8',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $perusahaan = Perusahaan::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil ditambahkan',
            'data' => $perusahaan,
        ], 201);
    }

    /**
     * Menampilkan detail perusahaan berdasarkan ID
     */
    public function show($id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'Perusahaan tidak ditemukan',
            ], 404);
        }

        return response()->json($perusahaan);
    }

    /**
     * Memperbarui data perusahaan
     */
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'Perusahaan tidak ditemukan',
            ], 404);
        }

        $validatedData = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:perusahaans,username,' . $id,
            'email' => 'sometimes|email|unique:perusahaans,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $perusahaan->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil diperbarui',
            'data' => $perusahaan,
        ]);
    }

    /**
     * Menghapus data perusahaan
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'Perusahaan tidak ditemukan',
            ], 404);
        }

        $perusahaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil dihapus',
        ]);
    }
}
