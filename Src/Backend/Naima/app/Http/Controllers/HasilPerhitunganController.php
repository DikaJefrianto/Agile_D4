<?php

namespace App\Http\Controllers;

use App\Models\Transportasi;
use App\Models\BahanBakar;
use App\Models\Biaya;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilPerhitunganController extends Controller
{
    public function index()
    {
        $bahanBakar = BahanBakar::all();
        $jenis = Transportasi::all();
        $jenisKendaraan = Biaya::all();

        $perhitungan = HasilPerhitungan::with(['bahanBakar', 'transportasi', 'biaya'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('perhitungan.index', compact('bahanBakar', 'jenis', 'jenisKendaraan', 'perhitungan'));
    }

    public function create(Request $request)
    {
        $kategori = $request->input('kategori');
        $metode = $request->input('metode');

        $bahanBakar = $kategori
            ? BahanBakar::where('kategori', $kategori)->get()
            : collect();

        $jenis = $kategori
            ? Transportasi::where('kategori', $kategori)->get()
            : collect();

        // Ambil biaya sesuai kategori jika ada
        $jenisKendaraan = $kategori
            ? Biaya::where('kategori', $kategori)->get()
            : collect();

        return view('perhitungan.create', compact('bahanBakar', 'jenis', 'jenisKendaraan', 'kategori', 'metode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_orang' => 'nullable|numeric|min:1',
            'nilai_input' => 'required|numeric|min:0',
            'metode' => 'required|in:bahan_bakar,jarak_tempuh,biaya',
        ]);

        $metode = $request->metode;
        $emisi = 0;

        $inputData = [
            'user_id' => Auth::id(),
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'jumlah_orang' => $request->jumlah_orang ?? 1,
            'nilai_input' => $request->nilai_input,
            'metode' => $metode,
        ];

        switch ($metode) {
            case 'bahan_bakar':
                $request->validate([
                    'Bahan_bakar' => 'required|exists:bahan_bakars,id',
                ]);

                $bahanBakar = BahanBakar::find($request->Bahan_bakar);
                if (!$bahanBakar) return back()->withErrors(['Bahan_bakar' => 'Data bahan bakar tidak ditemukan.']);

                $inputData['bahan_bakar_id'] = $bahanBakar->id;
                $emisi = $bahanBakar->factorEmisi * $request->nilai_input;
                break;

            case 'jarak_tempuh':
                $request->validate([
                    'jenis' => 'required|exists:transportasis,id',
                ]);

                $transportasi = Transportasi::find($request->jenis);
                if (!$transportasi) return back()->withErrors(['jenis' => 'Data transportasi tidak ditemukan.']);

                $inputData['transportasi_id'] = $transportasi->id;
                $emisi = $transportasi->factor_emisi * $request->nilai_input;
                break;

            case 'biaya':
                $request->validate([
                    'jenisKendaraan' => 'required|exists:biayas,id',
                ]);

                $biaya = Biaya::find($request->jenisKendaraan);
                if (!$biaya) return back()->withErrors(['jenisKendaraan' => 'Data biaya kendaraan tidak ditemukan.']);

                $inputData['biaya_id'] = $biaya->id;
                $emisi = $biaya->factorEmisi * $request->nilai_input * $request->jumlah_orang;
                break;
        }

        $inputData['hasil_emisi'] = $emisi;

        HasilPerhitungan::create($inputData);

        return redirect()->route('perhitungan.index')->with('success', 'Perhitungan emisi berhasil disimpan: ' . round($emisi, 4) . ' kg CO₂');
    }
    public function destroy($id)
    {
        $data = HasilPerhitungan::findOrFail($id);

        // Pastikan hanya data milik user yang sedang login yang boleh dihapus
        if ($data->user_id !== Auth::id()) {
            return redirect()->route('perhitungan.index')->withErrors('Anda tidak memiliki izin untuk menghapus data ini.');
        }

        $data->delete();

        return redirect()->route('perhitungan.index')->with('success', 'Data perhitungan berhasil dihapus.');
    }
}
