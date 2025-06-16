<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use App\Models\Biaya;
use App\Models\HasilPerhitungan;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HasilPerhitunganController extends Controller
{
    public function index()
    {
        $bahanBakar = BahanBakar::all();
        $jenis = Transportasi::all();
        $biayaList = Biaya::all();

        $perhitungan = HasilPerhitungan::with(['bahanBakar', 'transportasi', 'biaya'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $totalEmisi = HasilPerhitungan::where('user_id', auth()->id())->sum('hasil_emisi');

        return view('backend.pages.perhitungan.index', compact(
            'bahanBakar',
            'jenis',
            'biayaList',
            'perhitungan',
            'totalEmisi'
        ));
    }

    public function create(Request $request)
    {
        $kategori = $request->input('kategori');
        $metode = $request->input('metode');

        $bahanBakar = $kategori ? BahanBakar::where('kategori', $kategori)->get() : collect();
        $jenis = $kategori ? Transportasi::where('kategori', $kategori)->get() : collect();
        $jenisKendaraan = $kategori ? Biaya::where('kategori', $kategori)->get() : collect();

        return view('backend.pages.perhitungan.create', compact(
            'bahanBakar',
            'jenis',
            'jenisKendaraan',
            'kategori',
            'metode'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_orang' => 'nullable|numeric|min:1',
            'nilai_input' => 'required|numeric|min:0',
            'metode' => 'required|in:bahan_bakar,jarak_tempuh,biaya',
            'titik_awal' => 'required|string|max:255',
            'titik_tujuan' => 'required|string|max:255',
        ]);

        $jumlah_orang = $validated['jumlah_orang'] ?? 1;
        $emisi = 0;

        $data = array_merge($validated, [
            'user_id' => auth()->id(),
            'jumlah_orang' => $jumlah_orang,
        ]);

        switch ($validated['metode']) {
            case 'bahan_bakar':
                $request->validate(['Bahan_bakar' => 'required|exists:bahan_bakars,id']);
                $bb = BahanBakar::findOrFail($request->Bahan_bakar);
                $data['bahan_bakar_id'] = $bb->id;
                $emisi = $bb->factorEmisi * $validated['nilai_input'] * $jumlah_orang;
                break;

            case 'jarak_tempuh':
                $request->validate(['jenis' => 'required|exists:transportasis,id']);
                $tr = Transportasi::findOrFail($request->jenis);
                $data['transportasi_id'] = $tr->id;
                $emisi = $tr->factor_emisi * $validated['nilai_input'] * $jumlah_orang;
                break;

            case 'biaya':
                $request->validate(['jenisKendaraan' => 'required|exists:biayas,id']);
                $bi = Biaya::findOrFail($request->jenisKendaraan);
                $data['biaya_id'] = $bi->id;
                $emisi = $bi->factorEmisi * $validated['nilai_input'] * $jumlah_orang;
                break;
        }

        $data['hasil_emisi'] = $emisi;

        HasilPerhitungan::create($data);

        return redirect()->route('admin.perhitungan.index')
            ->with('success', 'Perhitungan emisi berhasil disimpan: ' . round($emisi, 4) . ' kg CO₂');
    }
    public function show($id)
    {
        $perhitungan = HasilPerhitungan::with(['bahanBakar', 'transportasi', 'biaya'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('backend.pages.perhitungan.show', compact('perhitungan'));
    }


    public function edit($id)
    {
        $perhitungan = HasilPerhitungan::findOrFail($id);

        if ($perhitungan->user_id !== auth()->id()) {
            return redirect()->route('admin.perhitungan.index')
                ->withErrors('Anda tidak diizinkan mengedit data ini.');
        }

        $kategori = $perhitungan->kategori;
        $metode = $perhitungan->metode;

        $bahanBakar = BahanBakar::where('kategori', $kategori)->get();
        $jenis = Transportasi::where('kategori', $kategori)->get();
        $biayaList = Biaya::where('kategori', $kategori)->get();

        return view('backend.pages.perhitungan.edit', compact(
            'perhitungan',
            'kategori',
            'metode',
            'bahanBakar',
            'jenis',
            'biayaList'
        ));
    }

    public function update(Request $request, $id)
    {
        $perhitungan = HasilPerhitungan::findOrFail($id);

        if ($perhitungan->user_id !== auth()->id()) {
            return redirect()->route('admin.perhitungan.index')
                ->withErrors('Anda tidak diizinkan mengubah data ini.');
        }

        $validated = $request->validate([
            'kategori' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_orang' => 'nullable|numeric|min:1',
            'nilai_input' => 'required|numeric|min:0',
            'metode' => 'required|in:bahan_bakar,jarak_tempuh,biaya',
            'titik_awal' => 'required|string|max:255',
            'titik_tujuan' => 'required|string|max:255',
        ]);

        $jumlah_orang = $validated['jumlah_orang'] ?? 1;
        $emisi = 0;

        $perhitungan->fill($validated);
        $perhitungan->jumlah_orang = $jumlah_orang;

        // Reset foreign key
        $perhitungan->bahan_bakar_id = null;
        $perhitungan->transportasi_id = null;
        $perhitungan->biaya_id = null;

        switch ($validated['metode']) {
            case 'bahan_bakar':
                $request->validate(['Bahan_bakar' => 'required|exists:bahan_bakars,id']);
                $bb = BahanBakar::findOrFail($request->Bahan_bakar);
                $perhitungan->bahan_bakar_id = $bb->id;
                $emisi = $bb->factorEmisi * $validated['nilai_input'] * $jumlah_orang;
                break;

            case 'jarak_tempuh':
                $request->validate(['jenis' => 'required|exists:transportasis,id']);
                $tr = Transportasi::findOrFail($request->jenis);
                $perhitungan->transportasi_id = $tr->id;
                $emisi = $tr->factor_emisi * $validated['nilai_input'] * $jumlah_orang;
                break;

            case 'biaya':
                $request->validate(['jenisKendaraan' => 'required|exists:biayas,id']);
                $bi = Biaya::findOrFail($request->jenisKendaraan);
                $perhitungan->biaya_id = $bi->id;
                $emisi = $bi->factorEmisi * $validated['nilai_input'] * $jumlah_orang;
                break;
        }

        $perhitungan->hasil_emisi = $emisi;
        $perhitungan->save();

        return redirect()->route('admin.perhitungan.index')
            ->with('success', 'Data berhasil diperbarui. Emisi: ' . round($emisi, 4) . ' kg CO₂');
    }

    public function destroy($id)
    {
        $data = HasilPerhitungan::findOrFail($id);

        if ($data->user_id !== auth()->id()) {
            return redirect()->route('admin.perhitungan.index')
                ->withErrors('Anda tidak memiliki izin untuk menghapus data ini.');
        }

        $data->delete();

        return redirect()->route('admin.perhitungan.index')
            ->with('success', 'Data perhitungan berhasil dihapus.');
    }
}
