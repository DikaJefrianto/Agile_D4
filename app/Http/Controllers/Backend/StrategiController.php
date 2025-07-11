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

class StrategiController extends Controller
{
    public function index()
    {
        $strategis = Strategi::all();
        return view('backend.strategis.index', compact('strategis'));
    }

    public function create()
    {
        return view('backend.strategis.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
        ]);

        Strategi::create($data);
        return redirect()->route('strategis.index')->with('success', 'Strategi berhasil ditambahkan.');
    }

    public function show(Strategi $strategi)
    {
        return view('backend.strategis.show', compact('strategi'));
    }

    public function edit(Strategi $strategi)
    {
        return view('backend.strategis.edit', compact('strategi'));
    }

    public function update(Request $request, Strategi $strategi)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
        ]);

        $strategi->update($data);
        return redirect()->route('strategis.index')->with('success', 'Strategi berhasil diperbarui.');
    }

    public function destroy(Strategi $strategi)
    {
        $strategi->delete();
        return redirect()->route('strategis.index')->with('success', 'Strategi berhasil dihapus.');
    }
}
