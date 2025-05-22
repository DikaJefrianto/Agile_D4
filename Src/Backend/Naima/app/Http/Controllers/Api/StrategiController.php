<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Strategi;

class StrategiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Strategi::with('perusahaan')->get();
        return view('strategi.index',compact('strategi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nama_program' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'in:draf,aktif,selesai',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');

        }


        $strategi = Strategi::create($validated);

        return response()->json($strategi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Strategi::with('perusahaan')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $strategi = Strategi::findOrFail($id);

        $validated = $request->validate([
            'nama_program' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'in:draf,aktif,selesai',
        ]);

        if ($request->hasFile('dokumen')) {
            // hapus file lama jika ada
            if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
                Storage::disk('public')->delete($strategi->dokumen);
            }
            $validated['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');
        }

        $strategi->update($validated);

        return response()->json($strategi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $strategi = Strategi::findOrFail($id);

        if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
            Storage::disk('public')->delete($strategi->dokumen);
        }

        $strategi->delete();

        return response()->json(['message' => 'Strategi deleted.']);
    }
}
