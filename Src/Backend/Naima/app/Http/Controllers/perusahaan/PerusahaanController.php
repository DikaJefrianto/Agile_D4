<?php
namespace App\Http\Controllers\perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan semua perusahaan
        $perusahaans = DB::table('perusahaans')->get();
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
            'email'      => 'required|email|unique:perusahaans,email|max:255',
            'password'   => 'required|string|min:6',
            'alamat'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Menyimpan data perusahaan menggunakan DB Facade
        DB::table('perusahaans')->insert([
            'nama'       => $request->nama,
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password), // Enkripsi password
            'alamat'     => $request->alamat,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('perusahaans.index')
            ->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail perusahaan
        $perusahaan = DB::table('perusahaans')->where('id', $id)->first();
        return view('perusahaans.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $perusahaan = DB::table('perusahaans')->where('id', $id)->first();
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
            'password'   => 'nullable|string|min:8', // Password boleh kosong
            'alamat'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Update data perusahaan menggunakan DB Facade
        DB::table('perusahaans')->where('id', $id)->update([
            'nama'       => $request->nama,
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => $request->password ? Hash::make($request->password) : DB::raw('password'), // Update password jika ada perubahan
            'alamat'     => $request->alamat,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);

        return redirect()->route('perusahaans.index')
            ->with('success', 'Perusahaan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data perusahaan menggunakan DB Facade
        DB::table('perusahaans')->where('id', $id)->delete();

        return redirect()->route('perusahaans.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}

