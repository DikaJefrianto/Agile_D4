<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perhitungan;

class PerhitunganController extends Controller
{
    public function index()
    {
        $perhitungan = Perhitungan::latest()->paginate(10);
        return view('perhitungan.index', compact('perhitungan'));
    }
    public function create()
    {
        return view('perhitungan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Validasi user_id yang ada di tabel users
            'transportasi' => 'required|string|max:255', // Validasi nama/jenis kendaraan
            'bahan_bakar' => 'required|string|max:255', // Validasi jenis bahan bakar
            'jarak_tempuh' => 'required|numeric|min:0', // Validasi jarak tempuh
            'emisi_dihasilkan' => 'required|numeric|min:0', // Validasi emisi yang dihasilkan
            'tanggal_perjalanan' => 'nullable|date', // Validasi tanggal perjalanan (opsional)
        ]);

        $emisi = $this->hitungEmisi($request->jarak_tempuh);

        Perhitungan::create($request->all());
        return redirect()->route('perhitungan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // private function hitungEmisi($jarak)
    // {
    //     // Contoh: 0.15 kg CO2e per km
    //     return $jarak * 0.15;
    // }
    public function hitungForm(Request $request)
    {
        // Ambil nilai dari session jika ada
        $hasil = $request->session()->get('hasil_emisi', null);

        return view('perhitungan.hitung', compact('hasil'));
    }

    /**
     * Proses perhitungan emisi berdasarkan metode terpilih
     */
    public function hitungEmisi(Request $request)
    {
        // Base validation: metode dan tanggal
        $rules = [
            'metode' => 'required|in:fuel,distance,spend',
            'tanggal_perjalanan' => 'required|date',
        ];

        // Tambah rules sesuai metode
        switch ($request->metode) {
            case 'fuel':
                $rules['vol_bahan'] = 'required|numeric|min:0';
                $rules['faktor_emisi'] = 'required|numeric|min:0';
                break;
            case 'distance':
                $rules['jarak_tempuh'] = 'required|numeric|min:0';
                $rules['faktor_per_km'] = 'required|numeric|min:0';
                break;
            case 'spend':
                $rules['biaya']         = 'required|numeric|min:0';
                $rules['faktor_eeio']   = 'required|numeric|min:0';
                break;
        }

        $data = $request->validate($rules);

        // Hitung emisi
        $emisi = 0;
        if ($data['metode'] === 'fuel') {
            // Emisi = vol bahan (L) × faktor emisi (kg CO₂e/L)
            $emisi = $data['vol_bahan'] * $data['faktor_emisi'];
        } elseif ($data['metode'] === 'distance') {
            // Emisi = jarak (km) × faktor per km (kg CO₂e/km)
            $emisi = $data['jarak_tempuh'] * $data['faktor_per_km'];
        } else {
            // Spend: Emisi = biaya (Rp) × faktor (kg CO₂e/Rp)
            $emisi = $data['biaya'] * $data['faktor_eeio'];
        }

        // Simpan hasil di session agar dapat ditampilkan di form
        // $request->session()->flash('hasil_emisi', $emisi);
        
        // Redirect ulang ke form
        return redirect()->route('perhitungan.hitungForm');
    }
}
