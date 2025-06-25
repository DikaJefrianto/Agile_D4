<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\HasilPerhitungan;
use App\Models\BahanBakar;
use App\Models\Transportasi;
use App\Models\Biaya;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan Anda sudah menginstal barryvdh/laravel-dompdf
use Carbon\Carbon; // Tambahkan ini untuk bekerja dengan tanggal


class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Pastikan Anda memiliki metode checkAuthorization atau gunakan middleware Spatie
            // Contoh Spatie: $this->middleware('permission:laporan.view');
            // Jika Anda belum mengimplementasikan checkAuthorization, hapus baris ini
            // atau ganti dengan middleware Spatie:
            // $this->checkAuthorization(auth()->user(), ['laporan.view']);
            return $next($request);
        });
    }

    public function index(Request $request): View
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        // --- TAMBAHKAN KODE INI ---
        $availableYears = HasilPerhitungan::select(DB::raw('YEAR(tanggal) as year'))
                                        ->distinct()
                                        ->orderBy('year', 'desc')
                                        ->pluck('year')
                                        ->toArray();

        // Jika tidak ada data perhitungan sama sekali, sediakan tahun saat ini sebagai opsi
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }
        // --- AKHIR TAMBAHAN KODE ---

        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        $aggregatedData = HasilPerhitungan::select(
                'karyawans.perusahaan_id',
                DB::raw('SUM(hasil_perhitungans.hasil_emisi) as total_emisi'),
                DB::raw('SUM(biayas.factorEmisi) as total_biaya_terkait'),
                DB::raw('COUNT(hasil_perhitungans.id) as total_perjalanan')
            )
            ->join('users', 'hasil_perhitungans.user_id', '=', 'users.id')
            ->join('karyawans', 'users.id', '=', 'karyawans.user_id')
            ->leftJoin('biayas', 'hasil_perhitungans.biaya_id', '=', 'biayas.id')
            ->whereMonth('hasil_perhitungans.tanggal', $bulan)
            ->whereYear('hasil_perhitungans.tanggal', $tahun)
            ->groupBy('karyawans.perusahaan_id')
            ->get()
            ->keyBy('perusahaan_id');

        $perusahaans = Perusahaan::all()->map(function($perusahaan) use ($aggregatedData, $daysInMonth) {
            $perusahaan->total_emisi_filtered = 0;
            $perusahaan->total_biaya_filtered = 0;
            $perusahaan->total_perjalanan = 0;
            $perusahaan->rata_rata_harian = 0;

            if ($aggregatedData->has($perusahaan->id)) {
                $data = $aggregatedData->get($perusahaan->id);
                $perusahaan->total_emisi_filtered = $data->total_emisi;
                $perusahaan->total_biaya_filtered = $data->total_biaya_terkait;
                $perusahaan->total_perjalanan = $data->total_perjalanan;
                if ($daysInMonth > 0) {
                    $perusahaan->rata_rata_harian = $data->total_emisi / $daysInMonth;
                }
            }
            return $perusahaan;
        });

        // Pastikan $emisiPerBahanBakar dan $emisiPerTransportasi juga didefinisikan
        // Jika belum ada, Anda bisa menambahkan query untuk ini juga.
        // Contoh sederhana (sesuaikan dengan kebutuhan Anda):
        $emisiPerBahanBakar = []; // Atau query dari database jika diperlukan
        $emisiPerTransportasi = []; // Atau query dari database jika diperlukan


        return view('backend.pages.laporan.index', compact(
            'perusahaans',
            'bulan',
            'tahun',
            'availableYears', // Variabel ini sekarang ada
            'emisiPerBahanBakar',
            'emisiPerTransportasi'
        ));
    }

    // Metode untuk ekspor PDF
    public function exportPdf(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        $aggregatedData = HasilPerhitungan::select(
                'users.id as user_id',
                DB::raw('SUM(hasil_perhitungans.hasil_emisi) as total_emisi'),
                DB::raw('SUM(biayas.factorEmisi) as total_biaya_terkait'),
                DB::raw('COUNT(hasil_perhitungans.id) as total_perjalanan')
            )
            ->join('users', 'hasil_perhitungans.user_id', '=', 'users.id')
            ->leftJoin('biayas', 'hasil_perhitungans.biaya_id', '=', 'biayas.id')
            ->whereMonth('hasil_perhitungans.tanggal', $bulan)
            ->whereYear('hasil_perhitungans.tanggal', $tahun)
            ->groupBy('users.id')
            ->get()
            ->keyBy('user_id');

        $perusahaans = Perusahaan::all()->map(function($perusahaan) use ($aggregatedData, $daysInMonth) {
            $perusahaan->total_emisi_filtered = 0;
            $perusahaan->total_biaya_filtered = 0;
            $perusahaan->total_perjalanan = 0;
            $perusahaan->rata_rata_harian = 0;

            if ($aggregatedData->has($perusahaan->user_id)) {
                $data = $aggregatedData->get($perusahaan->user_id);
                $perusahaan->total_emisi_filtered = $data->total_emisi;
                $perusahaan->total_biaya_filtered = $data->total_biaya_terkait;
                $perusahaan->total_perjalanan = $data->total_perjalanan;
                if ($daysInMonth > 0) {
                    $perusahaan->rata_rata_harian = $data->total_emisi / $daysInMonth;
                }
            }
            return $perusahaan;
        });

        // Load view 'pdf_laporan' (Anda harus membuat view ini) dengan data
        $pdf = Pdf::loadView('backend.pages.laporan.pdf_laporan', compact('perusahaans', 'bulan', 'tahun'));
        return $pdf->download('laporan_emisi_perusahaan_' . Carbon::create()->month($bulan)->translatedFormat('F_Y') . '.pdf');
    }

    // Metode untuk ekspor CSV
    public function exportCsv(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        $aggregatedData = HasilPerhitungan::select(
                'users.id as user_id',
                DB::raw('SUM(hasil_perhitungans.hasil_emisi) as total_emisi'),
                DB::raw('SUM(biayas.factorEmisi) as total_biaya_terkait'),
                DB::raw('COUNT(hasil_perhitungans.id) as total_perjalanan')
            )
            ->join('users', 'hasil_perhitungans.user_id', '=', 'users.id')
            ->leftJoin('biayas', 'hasil_perhitungans.biaya_id', '=', 'biayas.id')
            ->whereMonth('hasil_perhitungans.tanggal', $bulan)
            ->whereYear('hasil_perhitungans.tanggal', $tahun)
            ->groupBy('users.id')
            ->get()
            ->keyBy('user_id');

        $perusahaans = Perusahaan::all()->map(function($perusahaan) use ($aggregatedData, $daysInMonth) {
            $perusahaan->total_emisi_filtered = 0;
            $perusahaan->total_biaya_filtered = 0;
            $perusahaan->total_perjalanan = 0;
            $perusahaan->rata_rata_harian = 0;

            if ($aggregatedData->has($perusahaan->user_id)) {
                $data = $aggregatedData->get($perusahaan->user_id);
                $perusahaan->total_emisi_filtered = $data->total_emisi;
                $perusahaan->total_biaya_filtered = $data->total_biaya_terkait;
                $perusahaan->total_perjalanan = $data->total_perjalanan;
                if ($daysInMonth > 0) {
                    $perusahaan->rata_rata_harian = $data->total_emisi / $daysInMonth;
                }
            }
            return $perusahaan;
        });

        $filename = 'laporan_emisi_perusahaan_' . Carbon::create()->month($bulan)->translatedFormat('F_Y') . '.csv';
        $handle = fopen('php://temp', 'w+');

        // Tambahkan header CSV
        fputcsv($handle, ['No', 'Nama Perusahaan', 'Total Emisi (kg CO2)', 'Rata-rata Harian (kg CO2)', 'Banyak Perjalanan', 'Periode']);

        // Tambahkan data
        $no = 1;
        foreach ($perusahaans as $perusahaan) {
            fputcsv($handle, [
                $no++,
                $perusahaan->nama,
                number_format($perusahaan->total_emisi_filtered, 2, '.', ''),
                number_format($perusahaan->rata_rata_harian, 2, '.', ''),
                $perusahaan->total_perjalanan,
                Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y')
            ]);
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        return response($contents)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Anda bisa menambahkan metode export Excel di sini jika ingin menggunakan library seperti Laravel Excel (Maatwebsite)
    // Misalnya: public function exportExcel(Request $request) { ... }
    public function showDetail(Request $request, Perusahaan $perusahaan): View
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        // Ambil semua perhitungan emisi yang terkait dengan karyawan dari perusahaan ini
        // untuk periode yang dipilih.
        $detailPerhitungans = HasilPerhitungan::with(['user', 'transportasi', 'bahanBakar', 'biaya'])
            ->join('users', 'hasil_perhitungans.user_id', '=', 'users.id')
            ->join('karyawans', 'users.id', '=', 'karyawans.user_id')
            ->where('karyawans.perusahaan_id', $perusahaan->id)
            ->whereMonth('hasil_perhitungans.tanggal', $bulan)
            ->whereYear('hasil_perhitungans.tanggal', $tahun)
            ->orderBy('hasil_perhitungans.tanggal', 'asc')
            ->get();

        // Hitung ringkasan data untuk perusahaan ini (sama seperti di metode index/export)
        $totalEmisi = $detailPerhitungans->sum('hasil_emisi');
        $totalBiaya = $detailPerhitungans->sum(function($perhitungan) {
            return $perhitungan->biaya ? $perhitungan->biaya->factorEmisi : 0;
        });
        $totalPerjalanan = $detailPerhitungans->count();
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $rataRataHarian = ($daysInMonth > 0) ? $totalEmisi / $daysInMonth : 0;

        return view('backend.pages.laporan.detail_laporan', compact(
            'perusahaan',
            'bulan',
            'tahun',
            'detailPerhitungans',
            'totalEmisi',
            'totalBiaya',
            'totalPerjalanan',
            'rataRataHarian'
        ));
    }
    public function exportDetailPdf(Request $request, Perusahaan $perusahaan)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        $detailPerhitungans = HasilPerhitungan::with(['user', 'transportasi', 'bahanBakar', 'biaya'])
            ->join('users', 'hasil_perhitungans.user_id', '=', 'users.id')
            ->join('karyawans', 'users.id', '=', 'karyawans.user_id')
            ->where('karyawans.perusahaan_id', $perusahaan->id)
            ->whereMonth('hasil_perhitungans.tanggal', $bulan)
            ->whereYear('hasil_perhitungans.tanggal', $tahun)
            ->orderBy('hasil_perhitungans.tanggal', 'asc')
            ->get();

        $totalEmisi = $detailPerhitungans->sum('hasil_emisi');
        $totalBiaya = $detailPerhitungans->sum(function($perhitungan) {
            return $perhitungan->biaya ? $perhitungan->biaya->factorEmisi : 0;
        });
        $totalPerjalanan = $detailPerhitungans->count();
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $rataRataHarian = ($daysInMonth > 0) ? $totalEmisi / $daysInMonth : 0;

        $pdf = Pdf::loadView('backend.pages.laporan.pdf_detail_laporan', compact(
            'perusahaan',
            'bulan',
            'tahun',
            'detailPerhitungans',
            'totalEmisi',
            'totalBiaya',
            'totalPerjalanan',
            'rataRataHarian'
        ));

        $filename = 'detail_laporan_emisi_' . $perusahaan->nama . '_' . Carbon::create()->month($bulan)->translatedFormat('F_Y') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportDetailCsv(Request $request, Perusahaan $perusahaan)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        $detailPerhitungans = HasilPerhitungan::with(['user', 'transportasi', 'bahanBakar', 'biaya'])
            ->join('users', 'hasil_perhitungans.user_id', '=', 'users.id')
            ->join('karyawans', 'users.id', '=', 'karyawans.user_id')
            ->where('karyawans.perusahaan_id', $perusahaan->id)
            ->whereMonth('hasil_perhitungans.tanggal', $bulan)
            ->whereYear('hasil_perhitungans.tanggal', $tahun)
            ->orderBy('hasil_perhitungans.tanggal', 'asc')
            ->get();

        $filename = 'detail_laporan_emisi_' . $perusahaan->nama . '_' . Carbon::create()->month($bulan)->translatedFormat('F_Y') . '.csv';
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, [
            'No', 'Tanggal', 'Karyawan', 'Metode', 'Jenis (BB/Transportasi/Biaya)',
            'Nilai Input', 'Jumlah Orang', 'Emisi (kg CO2)', 'Biaya Terkait (Rp)', 'Rute'
        ]);

        $no = 1;
        foreach ($detailPerhitungans as $perhitungan) {
            $jenis = 'N/A';
            if ($perhitungan->metode == 'bahan_bakar' && $perhitungan->bahanBakar) {
                $jenis = $perhitungan->bahanBakar->Bahan_bakar . ' (' . $perhitungan->bahanBakar->kategori . ')';
            } elseif ($perhitungan->metode == 'jarak_tempuh' && $perhitungan->transportasi) {
                $jenis = $perhitungan->transportasi->jenis . ' (' . $perhitungan->transportasi->kategori . ')';
            } elseif ($perhitungan->metode == 'biaya' && $perhitungan->biaya) {
                $jenis = $perhitungan->biaya->jenisKendaraan . ' (' . $perhitungan->biaya->kategori . ')';
            }

            $nilaiInputFormatted = number_format($perhitungan->nilai_input, 2, '.', '');
            if ($perhitungan->metode == 'bahan_bakar') $nilaiInputFormatted .= ' Liter';
            elseif ($perhitungan->metode == 'jarak_tempuh') $nilaiInputFormatted .= ' km';
            elseif ($perhitungan->metode == 'biaya') $nilaiInputFormatted = 'Rp ' . number_format($perhitungan->nilai_input, 0, '.', ''); // Biaya di CSV mungkin lebih baik pakai nilai_input jika itu yang diisi user

            fputcsv($handle, [
                $no++,
                $perhitungan->tanggal->format('Y-m-d H:i'),
                $perhitungan->user->name ?? 'N/A',
                $perhitungan->metode,
                $jenis,
                $nilaiInputFormatted,
                $perhitungan->jumlah_orang,
                number_format($perhitungan->hasil_emisi, 2, '.', ''),
                number_format($perhitungan->biaya->factorEmisi ?? 0, 0, '.', ''),
                $perhitungan->titik_awal . ' - ' . $perhitungan->titik_tujuan
            ]);
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        return response($contents)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function exportDetailExcel(Request $request, Perusahaan $perusahaan)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        $filename = 'detail_laporan_emisi_' . $perusahaan->nama . '_' . Carbon::create()->month($bulan)->translatedFormat('F_Y') . '.xlsx';

        return Excel::download(new LaporanDetailPerusahaanExport($perusahaan->id, $bulan, $tahun), $filename);
    }
}
