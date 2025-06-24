<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use App\Models\Biaya;
use App\Models\HasilPerhitungan; // Perbaiki ini ke App\Models\HasilPerhitungan;
use App\Models\Transportasi; // Perbaiki ini ke App\Models\Transportasi;
use App\Models\Karyawan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class HasilPerhitunganController extends Controller
{
    /**
     * Helper function to check if the authenticated user has admin or superadmin role.
     * PENTING: Nama peran ('Admin', 'Superadmin') disesuaikan dengan case di database Anda.
     * @return bool
     */
    private function isAdminOrSuperAdmin(): bool
    {
        // Menggunakan 'Admin' dan 'Superadmin' dengan huruf kapital, sesuai database Anda.
        return Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Superadmin'));
    }

    /**
     * Helper function to get the authenticated user's associated Perusahaan ID.
     * Ini mempertimbangkan beberapa cara user mungkin terhubung ke perusahaan.
     * Mengembalikan null jika tidak terhubung atau user adalah Admin/Superadmin (karena mereka tidak memfilter berdasarkan satu perusahaan).
     * @return int|null
     */
    private function getAuthenticatedPerusahaanId(): ?int
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        // Admin/Superadmin tidak terkait langsung dengan satu perusahaan untuk filtering data ini
        if ($this->isAdminOrSuperAdmin()) {
            return null;
        }

        // Prioritas 1: Jika user dengan role 'Perusahaan' memiliki relasi 'perusahaan'
        if ($user->perusahaan) {
            return $user->perusahaan->id;
        }
        // Prioritas 2: Jika user dengan role 'Perusahaan' memiliki kolom 'perusahaan_id' langsung di tabel users
        elseif (isset($user->perusahaan_id)) {
            return $user->perusahaan_id;
        }
        // Prioritas 3: Jika user adalah representasi utama dari sebuah Perusahaan (Perusahaan.user_id = User.id)
        elseif ($perusahaan = Perusahaan::where('user_id', $user->id)->first()) {
            return $perusahaan->id;
        }

        return null;
    }

    // Constructor kosong karena checkAuthorization dipindahkan ke masing-masing method
    public function __construct()
    {
        // Middleware checkAuthorization telah dihapus dari sini.
        // Logika otorisasi akan ditangani secara inline di setiap metode.
    }

    /**
     * Display a listing of the resource (hasil perhitungan).
     * Admin/Superadmin: melihat semua.
     * Perusahaan: melihat milik sendiri dan karyawan.
     * Karyawan: melihat milik sendiri.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Admin dan Superadmin memiliki akses penuh, tidak perlu checkAuthorization di sini
        // karena filter query di bawah tidak akan diterapkan untuk mereka.
        if (!$this->isAdminOrSuperAdmin()) {
            // Untuk peran lain (Perusahaan, Karyawan), cek izin 'perhitungan.view'.
            // checkAuthorization ini akan memblokir jika tidak ada izin.
            $this->checkAuthorization($user, ['perhitungan.view']);
        }

        $query = HasilPerhitungan::with(['user', 'user.karyawan', 'user.karyawan.perusahaan', 'bahanBakar', 'transportasi', 'biaya']);

        // Menggunakan huruf kapital untuk semua pemeriksaan hasRole() sesuai database Anda.
        if ($user->hasRole('Perusahaan')) {
            $perusahaanId = $this->getAuthenticatedPerusahaanId();

            if ($perusahaanId) {
                $karyawanUserIds = Karyawan::where('perusahaan_id', $perusahaanId)->pluck('user_id')->toArray();
                $allowedUserIds = array_unique(array_merge([$user->id], $karyawanUserIds));
                $query->whereIn('user_id', $allowedUserIds);
            } else {
                Log::warning("Perusahaan ID tidak ditemukan untuk User ID: {$user->id}. Hanya menampilkan perhitungan pribadi.");
                $query->where('user_id', $user->id);
            }
        } elseif ($user->hasRole('Karyawan')) {
            $query->where('user_id', $user->id);
        }
        // Jika user adalah admin atau superadmin, tidak ada filter tambahan diterapkan,
        // sehingga mereka akan melihat semua data.

        $perhitungan = $query->latest()->paginate(10);
        $totalEmisi = $perhitungan->sum('hasil_emisi'); // Hitung total emisi dari data yang difilter

        $bahanBakar = BahanBakar::all();
        $jenis = Transportasi::all();
        $biayaList = Biaya::all();

        return view('backend.pages.perhitungan.index', compact(
            'bahanBakar',
            'jenis',
            'biayaList',
            'perhitungan',
            'totalEmisi'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $user = Auth::user();
        if (!$this->isAdminOrSuperAdmin()) {
            $this->checkAuthorization($user, ['perhitungan.create']);
        }
        // Lanjutkan ke form jika diizinkan

        $metodeOptions = [
            [ 'value' => 'bahan_bakar', 'icon' => 'bi-fuel-pump', 'color' => 'text-black-600', 'text' => 'Bahan Bakar', 'desc' => 'Gunakan data konsumsi bahan bakar', ],
            [ 'value' => 'jarak_tempuh', 'icon' => 'bi-geo-alt-fill', 'color' => 'text-black-600', 'text' => 'Jarak Tempuh', 'desc' => 'Gunakan data jarak perjalanan', ],
            [ 'value' => 'biaya', 'icon' => 'bi-cash-stack', 'color' => 'text-black-600', 'text' => 'Biaya', 'desc' => 'Gunakan data biaya perjalanan', ],
        ];
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
            'metode',
            'metodeOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if (!$this->isAdminOrSuperAdmin()) {
            $this->checkAuthorization($user, ['perhitungan.create']);
        }
        // Lanjutkan proses penyimpanan jika diizinkan

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

    /**
     * Display the specified resource.
     * Admin/Superadmin: bisa melihat semua.
     * Perusahaan: bisa melihat milik sendiri dan karyawan.
     * Karyawan: bisa melihat milik sendiri.
     */
    public function show(string $id): View
    {
        $perhitungan = HasilPerhitungan::with(['bahanBakar', 'transportasi', 'biaya', 'user', 'user.karyawan', 'user.karyawan.perusahaan'])->findOrFail($id);
        $user = Auth::user();

        // Admin dan Superadmin memiliki akses MUTLAK, langsung tampilkan view.
        if ($this->isAdminOrSuperAdmin()) {
            return view('backend.pages.perhitungan.show', compact('perhitungan'));
        }

        // Untuk peran lain, cek izin spesifik 'perhitungan.view'.
        // Ini adalah panggilan checkAuthorization yang benar untuk show().
        $this->checkAuthorization($user, ['perhitungan.view']);

        // Menggunakan huruf kapital untuk semua pemeriksaan hasRole() sesuai database Anda.
        if ($user->hasRole('Perusahaan')) {
            $perusahaanId = $this->getAuthenticatedPerusahaanId();
            if (
                $perhitungan->user_id === $user->id || // Milik user perusahaan itu sendiri
                ($perhitungan->user->karyawan && $perusahaanId && $perhitungan->user->karyawan->perusahaan_id === $perusahaanId) // Atau milik karyawan mereka
            ) {
                return view('backend.pages.perhitungan.show', compact('perhitungan'));
            }
        } elseif ($user->hasRole('Karyawan')) {
            // Karyawan hanya bisa melihat milik sendiri
            if ($perhitungan->user_id === $user->id) {
                return view('backend.pages.perhitungan.show', compact('perhitungan'));
            }
        }

        // Jika tidak ada kondisi di atas yang terpenuhi, tolak akses.
        abort(403, 'Anda tidak memiliki izin untuk melihat data ini.');
    }

    /**
     * Show the form for editing the specified resource.
     * Admin/Superadmin: bisa mengedit semua.
     * Perusahaan: bisa mengedit milik sendiri dan karyawan.
     * Karyawan: bisa mengedit milik sendiri.
     */
    public function edit(string $id): View
    {
        $perhitungan = HasilPerhitungan::findOrFail($id);
        $user = Auth::user();

        // Admin dan Superadmin memiliki akses MUTLAK.
        if ($this->isAdminOrSuperAdmin()) {
            // Lanjutkan ke bagian bawah metode ini untuk menampilkan form edit
        } else {
            // Untuk peran lain, cek izin spesifik 'perhitungan.update'.
            $this->checkAuthorization($user, ['perhitungan.update']); // Menggunakan 'update' untuk edit
        }

        // Menggunakan huruf kapital untuk semua pemeriksaan hasRole() sesuai database Anda.
        if ($user->hasRole('Perusahaan')) {
            $perusahaanId = $this->getAuthenticatedPerusahaanId();
            if (
                !($perhitungan->user_id === $user->id || // Bukan milik user perusahaan itu sendiri
                ($perhitungan->user->karyawan && $perusahaanId && $perhitungan->user->karyawan->perusahaan_id === $perusahaanId)) // Atau bukan milik karyawan mereka
            ) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit data ini.');
            }
        } elseif ($user->hasRole('Karyawan')) {
            // Karyawan hanya bisa mengedit milik sendiri
            if ($perhitungan->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit data ini.');
            }
        } else {
            // Jika tidak ada peran yang cocok di atas (misal, user anonim atau peran lain tanpa akses)
            abort(403, 'Anda tidak memiliki izin untuk mengedit data ini.');
        }

        // Kode di bawah ini akan tereksekusi hanya jika pengguna diizinkan oleh salah satu kondisi di atas
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

    /**
     * Update the specified resource in storage.
     * Admin/Superadmin: bisa mengupdate semua.
     * Perusahaan: bisa mengupdate milik sendiri dan karyawan.
     * Karyawan: bisa mengupdate milik sendiri.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $perhitungan = HasilPerhitungan::findOrFail($id);
        $user = Auth::user();

        // Admin dan Superadmin memiliki akses MUTLAK.
        if ($this->isAdminOrSuperAdmin()) {
            // Lanjutkan ke bagian bawah metode ini untuk menyimpan perubahan
        } else {
            // Untuk peran lain, cek izin spesifik 'perhitungan.update'.
            $this->checkAuthorization($user, ['perhitungan.update']);
        }

        // Menggunakan huruf kapital untuk semua pemeriksaan hasRole() sesuai database Anda.
        if ($user->hasRole('Perusahaan')) {
            $perusahaanId = $this->getAuthenticatedPerusahaanId();
            if (
                !($perhitungan->user_id === $user->id ||
                ($perhitungan->user->karyawan && $perusahaanId && $perhitungan->user->karyawan->perusahaan_id === $perusahaanId))
            ) {
                return redirect()->route('admin.perhitungan.index')
                    ->withErrors('Anda tidak memiliki izin untuk mengubah data ini.');
            }
        } elseif ($user->hasRole('Karyawan')) {
            if ($perhitungan->user_id !== $user->id) {
                return redirect()->route('admin.perhitungan.index')
                    ->withErrors('Anda tidak memiliki izin untuk mengubah data ini.');
            }
        } else {
            return redirect()->route('admin.perhitungan.index')
                ->withErrors('Anda tidak memiliki izin untuk mengubah data ini.');
        }

        // Kode di bawah ini akan tereksekusi hanya jika pengguna diizinkan oleh salah satu kondisi di atas
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
                $data['biaya_id'] = $bi->id;
                $emisi = $bi->factorEmisi * $validated['nilai_input'] * $jumlah_orang;
                break;
        }

        $perhitungan->hasil_emisi = $emisi;
        $perhitungan->save();

        return redirect()->route('admin.perhitungan.index')
            ->with('success', 'Data berhasil diperbarui. Emisi: ' . round($emisi, 4) . ' kg CO₂');
    }

    /**
     * Remove the specified resource from storage.
     * Admin/Superadmin: bisa menghapus semua.
     * Perusahaan: bisa menghapus milik sendiri dan karyawan.
     * Karyawan: tidak bisa menghapus.
     */
    public function destroy(string $id): RedirectResponse
    {
        $data = HasilPerhitungan::findOrFail($id);
        $user = Auth::user();

        // Admin dan Superadmin memiliki akses MUTLAK.
        if ($this->isAdminOrSuperAdmin()) {
            // Lanjutkan ke bagian bawah metode ini untuk menghapus data
        } else {
            // Untuk peran lain, cek izin spesifik 'perhitungan.delete'.
            $this->checkAuthorization($user, ['perhitungan.delete']);
        }

        // Menggunakan huruf kapital untuk semua pemeriksaan hasRole() sesuai database Anda.
        if ($user->hasRole('Perusahaan')) {
            $perusahaanId = $this->getAuthenticatedPerusahaanId();
            if (
                !($data->user_id === $user->id ||
                ($data->user->karyawan && $perusahaanId && $data->user->karyawan->perusahaan_id === $perusahaanId))
            ) {
                return redirect()->route('admin.perhitungan.index')
                    ->withErrors('Anda tidak memiliki izin untuk menghapus data ini.');
            }
        }
        // Logika untuk peran 'karyawan' (tidak diizinkan menghapus)
        elseif ($user->hasRole('Karyawan')) {
            // Karyawan tidak diizinkan menghapus. Langsung tolak.
            return redirect()->route('admin.perhitungan.index')
                ->withErrors('Anda tidak memiliki izin untuk menghapus data ini.');
        }
        // Jika tidak ada peran yang cocok di atas
        else { // Menambahkan 'else' eksplisit untuk menangani kasus jika tidak ada peran yang cocok
            return redirect()->route('admin.perhitungan.index')
                ->withErrors('Anda tidak memiliki izin untuk menghapus data ini.');
        }

        // Kode di bawah ini akan tereksekusi hanya jika pengguna diizinkan oleh salah satu kondisi di atas
        $data->delete();

        return redirect()->route('admin.perhitungan.index')
            ->with('success', 'Data perhitungan berhasil dihapus.');
    }
}
