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
class PerhitunganController extends Controller
{
    public function index()
    {
        $perhitungans = Perhitungan::with('perjalananDinas')->get();
        return view('backend.perhitungans.index', compact('perhitungans'));
    }

    public function create()
    {
        $perjalanans = PerjalananDinas::all();
        return view('backend.perhitungans.create', compact('perjalanans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'perjalanan_id' => 'required|exists:perjalanan_dinas,id',
            'total_emisi' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        Perhitungan::create($data);
        return redirect()->route('perhitungans.index')->with('success', 'Perhitungan berhasil ditambahkan.');
    }

    public function show(Perhitungan $perhitungan)
    {
        return view('backend.perhitungans.show', compact('perhitungan'));
    }

    public function edit(Perhitungan $perhitungan)
    {
        $perjalanans = PerjalananDinas::all();
        return view('backend.perhitungans.edit', compact('perhitungan', 'perjalanans'));
    }

    public function update(Request $request, Perhitungan $perhitungan)
    {
        $data = $request->validate([
            'perjalanan_id' => 'required|exists:perjalanan_dinas,id',
            'total_emisi' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        $perhitungan->update($data);
        return redirect()->route('perhitungans.index')->with('success', 'Perhitungan berhasil diperbarui.');
    }

    public function destroy(Perhitungan $perhitungan)
    {
        $perhitungan->delete();
        return redirect()->route('perhitungans.index')->with('success', 'Perhitungan berhasil dihapus.');
    }
}
