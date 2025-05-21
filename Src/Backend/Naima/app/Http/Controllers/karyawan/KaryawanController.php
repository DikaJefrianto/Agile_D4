<?php
namespace App\Http\Controllers\karyawan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Tampilkan semua karyawan.
     */
    public function index()
    {
        // Ambil semua data karyawan beserta perusahaan terkait
        $karyawans = \App\Models\Karyawan::with('perusahaan')->get();

        // // Debugging
        // dd($karyawans);

        return view('karyawans.index', compact('karyawans'));
    }

    /**
     * Tampilkan form tambah karyawan.
     */
    public function create()
    {
        $perusahaans = \App\Models\Perusahaan::all(); // Ambil semua data perusahaan
        return view('karyawans.create', compact('perusahaans'));
    }

    /**
     * Simpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:karyawans,email|max:255|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'role'          => 'required|in:karyawan',
            'no_telp'       => 'nullable|string|max:20',
            'foto'          => 'nullable|image|max:2048',
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_karyawan', 'public');
        }

        // Pastikan perusahaan tidak null
        $perusahaan = Auth::user()->perusahaan;
        if (!$perusahaan) {
            return redirect()->back()->withErrors(['error' => 'Perusahaan tidak ditemukan untuk pengguna ini.']);
        }

        // Simpan data karyawan di tabel karyawans
        $karyawan = $perusahaan->karyawans()->create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
            'no_telp'       => $request->no_telp,
            'foto'          => $fotoPath,
        ]);

        // Buat akun pengguna untuk karyawan di tabel users
        \App\Models\User::create([
            'name'          => $request->nama_lengkap,
            'email'         => $request->email,
            'password'      => Hash::make($request->password), // Enkripsi password
            'role'          => 'karyawan', // Tetapkan role sebagai karyawan
            'perusahaan_id' => $perusahaan->id, // Hubungkan dengan perusahaan
        ]);

        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil ditambahkan dan akun pengguna telah dibuat.');
    }

    /**
     * Tampilkan form edit karyawan.
     */
    public function edit($id)
    {
        // Ambil data karyawan menggunakan model Eloquent
        $karyawan = \App\Models\Karyawan::findOrFail($id);

        // Ambil data perusahaan untuk dropdown
        $perusahaans = \App\Models\Perusahaan::all();

        return view('karyawans.edit', compact('karyawan', 'perusahaans'));
    }

    /**
     * Update data karyawan.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:karyawans,email,' . $id,
            'password'     => 'nullable|min:6|confirmed',
            'role'         => 'required|in:admin,manajer,karyawan',
            'no_telp'      => 'nullable|string|max:20',
            'foto'         => 'nullable|image|max:2048',
        ]);

        // Mengambil data karyawan berdasarkan ID menggunakan DB Facade
        $karyawan = DB::table('karyawans')->where('id', $id)->first();

        // Jika password diisi, lakukan hashing
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Menyimpan foto baru jika ada dan menghapus foto lama jika ada
        if ($request->hasFile('foto')) {
            if ($karyawan && $karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
        }

        // Mengupdate data karyawan menggunakan DB Facade
        DB::table('karyawans')->where('id', $id)->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'],
            'password'     => $validated['password'] ?? $karyawan->password,
            'role'         => $validated['role'],
            'no_telp'      => $validated['no_telp'],
            'foto'         => $validated['foto'] ?? $karyawan->foto,
            'updated_at'   => now(),
        ]);

        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Hapus karyawan.
     */
    public function destroy($id)
    {
        // Mengambil data karyawan berdasarkan ID
        $karyawan = DB::table('karyawans')->where('id', $id)->first();

        // Menghapus foto karyawan jika ada
        if ($karyawan && $karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
        }

        // Menghapus karyawan dari database
        DB::table('karyawans')->where('id', $id)->delete();

        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
