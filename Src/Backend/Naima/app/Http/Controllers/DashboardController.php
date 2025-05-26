<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPerhitungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        $userId = Auth::id();

        // Total perjalanan user
        $jumlahPerjalanan = HasilPerhitungan::where('user_id', $userId)->count();

        // Total emisi keseluruhan
        $totalEmisi = HasilPerhitungan::where('user_id', $userId)->sum('hasil_emisi');

        // Rata-rata emisi per perjalanan
        $rataRataEmisi = $jumlahPerjalanan > 0 ? $totalEmisi / $jumlahPerjalanan : 0;

        // Emisi per bulan (grafik)
        $dataBulanan = HasilPerhitungan::selectRaw('MONTH(tanggal) as bulan, SUM(hasil_emisi) as total')
            ->where('user_id', $userId)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Format data untuk Chart.js
        $bulan = [];
        $totalEmisiBulanan = [];

        foreach ($dataBulanan as $row) {
            $bulan[] = Carbon::create()->month($row->bulan)->translatedFormat('F'); // contoh: Januari
            $totalEmisiBulanan[] = round($row->total, 2);
        }

        return view('dashboard', compact(
            'jumlahPerjalanan',
            'totalEmisi',
            'rataRataEmisi',
            'bulan',
            'totalEmisiBulanan'
        ));
    }
}
