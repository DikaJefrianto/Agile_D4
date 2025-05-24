<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPerhitungan;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        $perhitungan = HasilPerhitungan::all();

        $totalPerhitungan = $perhitungan->count();
        $totalEmisi = $perhitungan->sum('emisi_dihasilkan');

        $metodeFavorit = $perhitungan->groupBy('metode')
            ->sortByDesc(fn($group) => $group->count())
            ->keys()
            ->first();

        // Untuk grafik
        $data = $perhitungan->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal_perjalanan)->format('M Y');
        });

        $bulan = $data->keys()->toArray();
        $dataEmisi = $data->map(function ($group) {
            return round($group->sum('emisi_dihasilkan'), 2);
        })->values()->toArray();

        return view('dashboard', compact(
            'totalPerhitungan',
            'totalEmisi',
            'metodeFavorit',
            'bulan',
            'dataEmisi'
        ));
    }
}
