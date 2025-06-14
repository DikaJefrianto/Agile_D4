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
class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('bahanBakar')->get();
        return view('backend.kendaraans.index', compact('kendaraans'));
    }

    public function create()
    {
        $bahanBakars = BahanBakar::all();
        return view('backend.kendaraans.create', compact('bahanBakars'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis' => 'required|string|max:255',
            'bahan_bakar_id' => 'required|exists:bahan_bakars,id',
            'efisiensi_km_per_liter' => 'required|numeric',
        ]);

        Kendaraan::create($data);
        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Kendaraan $kendaraan)
    {
        return view('backend.kendaraans.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        $bahanBakars = BahanBakar::all();
        return view('backend.kendaraans.edit', compact('kendaraan', 'bahanBakars'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate([
            'jenis' => 'required|string|max:255',
            'bahan_bakar_id' => 'required|exists:bahan_bakars,id',
            'efisiensi_km_per_liter' => 'required|numeric',
        ]);

        $kendaraan->update($data);
        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();
        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
