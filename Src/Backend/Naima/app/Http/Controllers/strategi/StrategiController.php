<?php

namespace App\Http\Controllers\strategi;

use App\Http\Controllers\Controller;
use App\Models\Strategi;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrategiController extends Controller
{
    public function index()
    {
        $strategis = Strategi::with('perusahaan')->get();
        return view('strategi.index', compact('strategis'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::all();
        return view('strategi.create', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:draf,aktif,selesai',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');
        }

        Strategi::create($validated);

        return redirect()->route('strategi.index')->with('success', 'Strategi berhasil ditambahkan.');
    }

    public function show(Strategi $strategi)
    {
        return view('strategi.show', compact('strategi'));
    }

    public function edit(Strategi $strategi)
    {
        $perusahaans = Perusahaan::all();
        return view('strategi.edit', compact('strategi', 'perusahaans'));
    }

    public function update(Request $request, Strategi $strategi)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:draf,aktif,selesai',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
                Storage::disk('public')->delete($strategi->dokumen);
            }

            $validated['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');
        }

        $strategi->update($validated);

        return redirect()->route('strategi.index')->with('success', 'Strategi berhasil diperbarui.');
    }

    public function destroy(Strategi $strategi)
    {
        if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
            Storage::disk('public')->delete($strategi->dokumen);
        }

        $strategi->delete();

        return redirect()->route('strategi.index')->with('success', 'Strategi berhasil dihapus.');
    }
}
