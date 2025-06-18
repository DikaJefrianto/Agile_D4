<?php

namespace App\Http\Controllers\Backend;

use App\Models\Perusahaan;
use App\Models\Karyawan;
use App\Models\Strategi;
use App\Models\BahanBakar;
use App\Models\Kendaraan;
use App\Models\Feedback;
use App\Models\PerjalananDinas;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BahanBakarController extends Controller
{
    public function index()
    {
        $bahanBakars = BahanBakar::all();
        return view('backend.bahan-bakars.index', compact('bahanBakars'));
    }

    public function create()
    {
        return view('backend.bahan-bakars.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'emisi_per_liter' => 'required|numeric',
        ]);

        BahanBakar::create($data);
        return redirect()->route('bahan-bakars.index')->with('success', 'Bahan bakar berhasil ditambahkan.');
    }

    public function show(BahanBakar $bahanBakar)
    {
        return view('backend.bahan-bakars.show', compact('bahanBakar'));
    }

    public function edit(BahanBakar $bahanBakar)
    {
        return view('backend.bahan-bakars.edit', compact('bahanBakar'));
    }

    public function update(Request $request, BahanBakar $bahanBakar)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'emisi_per_liter' => 'required|numeric',
        ]);

        $bahanBakar->update($data);
        return redirect()->route('bahan-bakars.index')->with('success', 'Bahan bakar berhasil diperbarui.');
    }

    public function destroy(BahanBakar $bahanBakar)
    {
        $bahanBakar->delete();
        return redirect()->route('bahan-bakars.index')->with('success', 'Bahan bakar berhasil dihapus.');
    }
}
