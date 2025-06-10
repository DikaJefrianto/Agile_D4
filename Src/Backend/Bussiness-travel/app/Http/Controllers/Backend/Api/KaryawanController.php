<?php
namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('user')->get();
        return response()->json([
            'status' => 'success',
            'data'   => $karyawans,
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'no_hp'         => 'required|string|max:15',
            'alamat'        => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'foto'          => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('karyawan-photos', 'public');
        }

        // Simpan user terlebih dahulu
        $user = User::create([
            'name'     => $data['nama_lengkap'],
            'email'    => $data['email'],
            'username' => strtolower(str_replace(' ', '_', $data['nama_lengkap'])),
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('Karyawan');

        // Simpan data karyawan
        Karyawan::create([
            'nama_lengkap'  => $data['nama_lengkap'],
            'no_hp'         => $data['no_hp'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'jabatan'       => $data['jabatan'] ?? null,
            'foto'          => $fotoPath,
            'user_id'       => $user->id,
            'perusahaan_id' => $data['perusahaan_id'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Karyawan dan User berhasil ditambahkan',
            'data'    => $karyawan,
        ], 201);
    }

    public function show($id)
    {
        $karyawan = Karyawan::with('user')->find($id);
        if (! $karyawan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $karyawan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        if (! $karyawan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        }

        $validatedData = $request->validate([
            'nama_lengkap'  => 'nullable|string|max:255',
            'email'         => 'nullable|email|unique:users,email,' . $karyawan->user_id,
            'password'      => 'nullable|string|min:6',
            'role'          => 'nullable|string',
            'no_telp'       => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'perusahaan_id' => 'nullable|exists:perusahaans,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('karyawan-photos', 'public');
        }

        // Update karyawan
        $karyawan->update($validatedData);

        // Update user terkait
        $user = $karyawan->user;
        if ($user) {
            $user->update([
                'name'          => $validatedData['nama_lengkap'] ?? $user->name,
                'email'         => $validatedData['email'] ?? $user->email,
                'role'          => $validatedData['role'] ?? $user->role,
                'password'      => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password,
                'perusahaan_id' => $validatedData['perusahaan_id'] ?? $user->perusahaan_id,
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Karyawan dan User berhasil diperbarui',
            'data'    => $karyawan,
        ]);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        if (! $karyawan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        }

        if ($karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
        }

        // Hapus user terkait
        if ($karyawan->user) {
            $karyawan->user->delete();
        }

        $karyawan->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Karyawan dan User berhasil dihapus',
        ]);
    }
}
