<?php
namespace App\Http\Controllers\pengguna;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    /**
     * Tampilkan semua pengguna.
     */
    public function index()
    {
        // Mengambil semua data pengguna menggunakan DB Facade
        $penggunas = DB::table('penggunas')->get();
        return view('penggunas.index', compact('penggunas'));
    }

    /**
     * Tampilkan form tambah pengguna.
     */
    public function create()
    {
        $perusahaans = \App\Models\Perusahaan::all(); // atau model perusahaanmu
        return view('penggunas.create', compact('perusahaans'));
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:penggunas,email',
            'password'     => 'required|min:6|confirmed',
            'role'         => 'required|in:admin,manajer,karyawan',
            'no_telp'      => 'nullable|string|max:20',
            'foto'         => 'nullable|image|max:2048',
        ]);

        // Menyimpan foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_pengguna', 'public');
        }

        // Menyimpan data pengguna ke tabel menggunakan DB facade
        DB::table('penggunas')->insert([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'],
            'password'     => bcrypt($validated['password']), // Meng-hash password sebelum disimpan
            'role'         => $validated['role'],
            'no_telp'      => $validated['no_telp'],
            'foto'         => $validated['foto'] ?? null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('penggunas.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit pengguna.
     */
    public function edit($id)
    {
        $pengguna    = Pengguna::findOrFail($id);
        $perusahaans = \App\Models\Perusahaan::all();
        return view('penggunas.edit', compact('pengguna', 'perusahaans'));
    }

    /**
     * Update data pengguna.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:penggunas,email,' . $id,
            'password'     => 'nullable|min:6|confirmed',
            'role'         => 'required|in:admin,manajer,karyawan',
            'no_telp'      => 'nullable|string|max:20',
            'foto'         => 'nullable|image|max:2048',
        ]);

        // Mengambil data pengguna berdasarkan ID menggunakan DB Facade
        $pengguna = DB::table('penggunas')->where('id', $id)->first();

        // Jika password diisi, lakukan hashing
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Menyimpan foto baru jika ada dan menghapus foto lama jika ada
        if ($request->hasFile('foto')) {
            if ($pengguna && $pengguna->foto) {
                Storage::disk('public')->delete($pengguna->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_pengguna', 'public');
        }

        // Mengupdate data pengguna menggunakan DB Facade
        DB::table('penggunas')->where('id', $id)->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'],
            'password'     => $validated['password'] ?? $pengguna->password,
            'role'         => $validated['role'],
            'no_telp'      => $validated['no_telp'],
            'foto'         => $validated['foto'] ?? $pengguna->foto,
            'updated_at'   => now(),
        ]);

        return redirect()->route('penggunas.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna.
     */
    public function destroy($id)
    {
        // Mengambil data pengguna berdasarkan ID
        $pengguna = DB::table('penggunas')->where('id', $id)->first();

        // Menghapus foto pengguna jika ada
        if ($pengguna && $pengguna->foto) {
            Storage::disk('public')->delete($pengguna->foto);
        }

        // Menghapus pengguna dari database
        DB::table('penggunas')->where('id', $id)->delete();

        return redirect()->route('penggunas.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
