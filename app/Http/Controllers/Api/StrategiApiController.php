<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Strategi;
use Illuminate\Http\Request;

class StrategiApiController extends Controller
{
    public function index()
    {
        return response()->json(Strategi::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_program' => 'required|string',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'perusahaan_id' => 'required|exists:perusahaans,id'
        ]);

        $strategi = Strategi::create($data);

        return response()->json($strategi, 201);
    }
    public function update(Request $request, $id)
    {
        $strategi = Strategi::findOrFail($id);

        $data = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'perusahaan_id' => 'required|exists:perusahaans,id',
        ]);

        $strategi->update($data);

        return response()->json([
            'message' => 'Strategi updated successfully',
            'data' => $strategi
        ]);
    }

    public function destroy($id)
    {
        $strategi = Strategi::findOrFail($id);
        $strategi->delete();

        return response()->json([
            'message' => 'Strategi deleted successfully'
        ]);
    }
}
