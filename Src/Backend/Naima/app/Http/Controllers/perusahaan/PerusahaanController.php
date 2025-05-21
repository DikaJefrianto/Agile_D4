<?php

namespace App\Http\Controllers\perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan semua perusahaan menggunakan Eloquent
        $perusahaans = Perusahaan::all();
        return view('perusahaans.index', compact('perusahaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form tambah perusahaan
        return view('perusahaans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'       => 'required|string|max:255',
            'username'   => 'required|string|unique:perusahaans,username|max:255',
            'email'      => 'required|email|unique:perusahaans,email|max:255|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'alamat'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Buat data perusahaan di tabel perusahaans
        $perusahaan = Perusahaan::create([
            'nama'       => $request->nama,
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password), // Enkripsi password
            'alamat'     => $request->alamat,
            'keterangan' => $request->keterangan,
        ]);

        // Buat akun pengguna untuk perusahaan di tabel users
        User::create([
            'name'          => $request->nama,
            'email'         => $request->email,
            'password'      => Hash::make($request->password), // Enkripsi password
            'role'          => 'perusahaan', // Tetapkan role sebagai perusahaan
            'perusahaan_id' => $perusahaan->id, // Hubungkan dengan perusahaan
        ]);

        return redirect()->route('perusahaans.index')
            ->with('success', 'Perusahaan berhasil ditambahkan dan dapat login.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail perusahaan menggunakan Eloquent
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaans.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan form edit perusahaan menggunakan Eloquent
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaans.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama'       => 'required|string|max:255',
            'username'   => 'required|string|unique:perusahaans,username,' . $id . '|max:255',
            'email'      => 'required|email|unique:perusahaans,email,' . $id . '|max:255',
            'password'   => 'nullable|string|min:8|confirmed', // Password boleh kosong
            'alamat'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Update data perusahaan menggunakan Eloquent
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update([
            'nama'       => $request->nama,
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => $request->password ? Hash::make($request->password) : $perusahaan->password, // Update password jika ada perubahan
            'alamat'     => $request->alamat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('perusahaans.index')
            ->with('success', 'Perusahaan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data perusahaan menggunakan Eloquent
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaans.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}

