<?php
namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Perusahaan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    /**
     * Tampilkan semua karyawan.
     */
    public function index(Request $request)
    {
        // Ambil query parameter untuk pencarian
        $search = $request->input('search');

        // Ambil data karyawan dengan pagination dan filter
        $karyawans = Karyawan::with('perusahaan')->when($search, function ($query, $search) {
            return $query->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(5); // Pastikan ini mengembalikan paginator

        return view('karyawans.index', compact('karyawans', 'search'));
    }

    /**
     * Tampilkan form tambah karyawan.
     */
    public function create()
    {
        $perusahaans = Perusahaan::all();
        return view('karyawans.create', compact('perusahaans'));
    }

    /**
     * Simpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:karyawans,email|unique:users,email|max:255',
            'password'     => 'required|string|min:8|confirmed',
            'no_telp'      => 'nullable|string|max:30',
            'foto'         => 'nullable|image|mimes:jpeg,jpg,png|max:4096', // max 4MB
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            try {
                $file = $request->file('foto');
                if ($file->isValid()) {
                    $fotoPath = $file->store('foto_karyawan', 'public');
                }
            } catch (Exception $e) {
                Log::error('Error uploading file: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah foto. Silakan coba lagi dengan ukuran file maksimal 4MB.');
            }
        }

        // Dapatkan perusahaan dari pengguna yang sedang login
        $perusahaan = Auth::user()->perusahaan;
        if (! $perusahaan) {
            return redirect()->back()->withErrors(['error' => 'Perusahaan tidak ditemukan untuk pengguna ini.']);
        }

        try {
            // Buat akun pengguna untuk karyawan di tabel users
            $user = User::create([
                'name'          => $validated['nama_lengkap'],
                'email'         => $validated['email'],
                'password'      => Hash::make($validated['password']),
                'role'          => 'karyawan',
                'perusahaan_id' => $perusahaan->id,
            ]);

            // Simpan data karyawan di tabel karyawans
            $karyawan = Karyawan::create([
                'nama_lengkap'  => $validated['nama_lengkap'],
                'email'         => $validated['email'],
                'password'      => Hash::make($validated['password']),
                'role'          => 'karyawan',
                'no_telp'       => $validated['no_telp'],
                'foto'          => $fotoPath,
                'perusahaan_id' => $perusahaan->id,
                'user_id'       => $user->id,
            ]);

            return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil ditambahkan dan akun pengguna telah dibuat.');
        } catch (Exception $e) {
            // Jika terjadi error, hapus foto yang sudah diupload
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            Log::error('Error creating karyawan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan form edit karyawan.
     */
    public function edit($id)
    {
        $karyawan    = Karyawan::findOrFail($id);
        $perusahaans = Perusahaan::all();
        return view('karyawans.edit', compact('karyawan', 'perusahaans'));
    }

    /**
     * Update data karyawan.
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:karyawans,email,' . $id,
            'password'     => 'nullable|min:8|confirmed',
            'no_telp'      => 'nullable|string|max:30',
            'foto'         => 'nullable|image|mimes:jpeg,jpg,png|max:4096', // max 4MB
        ]);

        try {
            // Update password jika diisi
            if ($request->filled('password')) {
                $karyawan->password = Hash::make($validated['password']);
            }
            // Update foto jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                if ($file->isValid()) {
                    // Hapus foto lama jika ada
                    if ($karyawan->foto && Storage::disk('public')->exists($karyawan->foto)) {
                        Storage::disk('public')->delete($karyawan->foto);
                    }
                    // Simpan foto baru
                    $karyawan->foto = $file->store('foto_karyawan', 'public');
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'File foto tidak valid. Silakan coba lagi.');
                }
            }
            $karyawan->nama_lengkap = $validated['nama_lengkap'];
            $karyawan->email        = $validated['email'];
            $karyawan->no_telp      = $validated['no_telp'];
            $karyawan->save();

            // Update data user terkait
            if ($karyawan->user) {
                $user        = $karyawan->user;
                $user->name  = $validated['nama_lengkap'];
                $user->email = $validated['email'];
                if ($request->filled('password')) {
                    $user->password = Hash::make($validated['password']);
                }
                $user->save();
            }

            return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error('Error updating karyawan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Hapus karyawan.
     */
    public function destroy($id)
    {
        try {
            $karyawan = Karyawan::findOrFail($id);
            // Hapus foto jika ada
            if ($karyawan->foto && Storage::disk('public')->exists($karyawan->foto)) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            // Hapus user terkait
            if ($karyawan->user) {
                $karyawan->user->delete();
            }
            // Hapus karyawan
            $karyawan->delete();
            return redirect()->route('karyawans.index')->with('success', 'Karyawan dan akun pengguna berhasil dihapus.');
        } catch (Exception $e) {
            Log::error('Error deleting karyawan: ' . $e->getMessage());
            return redirect()->route('karyawans.index')->with('error', 'Terjadi kesalahan saat menghapus karyawan.');
        }
    }
}
