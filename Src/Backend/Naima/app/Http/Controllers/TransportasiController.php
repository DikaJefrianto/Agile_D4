<?php

namespace App\Http\Controllers;

use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data transportasi dari database
        $transportasis = Transportasi::orderBy('kategori')->get();

        // Kirim ke view
        return view('transportasi.index', compact('transportasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transportasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'jenis' => 'required|string|max:100',
            'factor_emisi' => 'required|numeric|min:0',
        ]);

        Transportasi::create([
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'factor_emisi' => $request->factor_emisi,
        ]);

        return redirect()->route('transportasi.index')->with('success', 'Data transportasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transportasi $transportasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transportasi = DB::table('transportasis')->where('id', $id)->first();
        return view('transportasi.edit', compact('transportasi')); // <-- gunakan nama sesuai Blade
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'factor_emisi' => 'required|numeric',
        ]);

        DB::table('transportasis')
            ->where('id', $id)
            ->update([
                'kategori' => $request->kategori,
                'jenis' => $request->jenis,
                'factor_emisi' => $request->factor_emisi,
                'updated_at' => now()
            ]);

        return redirect()->route('transportasi.index')->with('success', 'Data Transportasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data berdasarkan ID
        DB::table('transportasis')->where('id', $id)->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('transportasi.index')->with('success', 'Data transportasi berhasil dihapus');
    }
}
