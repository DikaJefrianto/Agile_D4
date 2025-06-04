<?php

namespace App\Http\Controllers;

use App\Models\BahanBakar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanBakarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        if ($kategori) {
            $bahan_bakars = BahanBakar::where('kategori', $kategori)->get();
        } else {
            $bahan_bakars = BahanBakar::all();
        }
        // Ambil semua data transportasi dari database
        // $bahan_bakars = BahanBakar::orderBy('kategori')->get();

        // Kirim ke view
        return view('BahanBakar.index', compact('bahan_bakars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('BahanBakar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'Bahan_bakar' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        BahanBakar::create([
            'kategori' => $request->kategori,
            'Bahan_bakar' => $request->Bahan_bakar,
            'factorEmisi' => $request->factorEmisi,
        ]);

        return redirect()->route('BahanBakar.index')->with('success', 'Data transportasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanBakar $bahanBakar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $BahanBakar = DB::table('bahan_bakars')->where('id', $id)->first();
        return view('BahanBakar.edit', compact('BahanBakar')); // <-- gunakan nama sesuai Blade
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'Bahan_bakar' => 'required|string|max:255',
            'factorEmisi' => 'required|numeric',
        ]);

        DB::table('bahan_bakars')
            ->where('id', $id)
            ->update([
                'kategori' => $request->kategori,
                'Bahan_bakar' => $request->Bahan_bakar,
                'factorEmisi' => $request->factorEmisi,
                'updated_at' => now()
            ]);

        return redirect()->route('BahanBakar.index')->with('success', 'Data Transportasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data berdasarkan ID
        DB::table('bahan_bakars')->where('id', $id)->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('BahanBakar.index')->with('success', 'Data transportasi berhasil dihapus');
    }
}
