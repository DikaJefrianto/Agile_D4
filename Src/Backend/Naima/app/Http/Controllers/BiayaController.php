<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data transportasi dari database
        $biayas = Biaya::orderBy('kategori')->get();

        // Kirim ke view
        return view('biaya.index', compact('biayas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('biaya.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'jenisKendaraan' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        Biaya::create([
            'kategori' => $request->kategori,
            'jenisKendaraan' => $request->jenisKendaraan,
            'factorEmisi' => $request->factorEmisi,
        ]);

        return redirect()->route('biaya.index')->with('success', 'Data transportasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Biaya $biaya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $biaya = DB::table('biayas')->where('id', $id)->first();
        return view('biaya.edit', compact('biaya')); // <-- gunakan nama sesuai Blade
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'jenisKendaraan' => 'required|string|max:255',
            'factorEmisi' => 'required|numeric',
        ]);

        DB::table('biayas')
            ->where('id', $id)
            ->update([
                'kategori' => $request->kategori,
                'jenisKendaraan' => $request->jenisKendaraan,
                'factorEmisi' => $request->factorEmisi,
                'updated_at' => now()
            ]);

        return redirect()->route('biaya.index')->with('success', 'Data Transportasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data berdasarkan ID
        DB::table('biayas')->where('id', $id)->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('biaya.index')->with('success', 'Data transportasi berhasil dihapus');
    }
}
