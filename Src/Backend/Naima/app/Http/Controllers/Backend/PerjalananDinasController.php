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

class PerjalananDinasController extends Controller
{
    public function index()
    {
        $perjalanans = PerjalananDinas::with('karyawan')->get();
        return view('backend.perjalanan-dinas.index', compact('perjalanans'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('backend.perjalanan-dinas.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tujuan' => 'required|string|max:255',
            'mode_transportasi' => 'required|in:mobil,kereta,pesawat',
            'jarak_km' => 'required|numeric',
        ]);

        PerjalananDinas::create($data);
        return redirect()->route('perjalanan-dinas.index')->with('success', 'Perjalanan dinas berhasil ditambahkan.');
    }

    public function show(PerjalananDinas $perjalananDinas)
    {
        return view('backend.perjalanan-dinas.show', compact('perjalananDinas'));
    }

    public function edit(PerjalananDinas $perjalananDinas)
    {
        $karyawans = Karyawan::all();
        return view('backend.perjalanan-dinas.edit', compact('perjalananDinas', 'karyawans'));
    }

    public function update(Request $request, PerjalananDinas $perjalananDinas)
    {
        $data = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tujuan' => 'required|string|max:255',
            'mode_transportasi' => 'required|in:mobil,kereta,pesawat',
            'jarak_km' => 'required|numeric',
        ]);

        $perjalananDinas->update($data);
        return redirect()->route('perjalanan-dinas.index')->with('success', 'Perjalanan dinas berhasil diperbarui.');
    }

    public function destroy(PerjalananDinas $perjalananDinas)
    {
        $perjalananDinas->delete();
        return redirect()->route('perjalanan-dinas.index')->with('success', 'Perjalanan dinas berhasil dihapus.');
    }
}
