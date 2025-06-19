<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transportasi;
use Illuminate\Http\Request;

class TransportasiController extends Controller
{
    /**
     * Tampilkan daftar transportasi.
     */
    public function index(Request $request)
    {
        $transportasis = Transportasi::query()
            ->when($request->filled('kategori'), fn($q) => $q->where('kategori', $request->kategori))
            ->when($request->filled('search'), fn($q) => $q->where('jenis', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.transportasi.index', compact('transportasis'));
    }

    /**
     * Tampilkan form tambah data transportasi.
     */
    public function create()
    {
        return view('backend.pages.transportasi.create');
    }

    /**
     * Simpan data transportasi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jenis' => 'required|string|max:100',
            'factor_emisi' => 'required|numeric|min:0',
        ]);

        Transportasi::create($validated);

        return redirect()->route('admin.transportasi.index')
            ->with('success', 'Data transportasi berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit transportasi.
     */
    public function edit(Transportasi $transportasi)
    {
        return view('backend.pages.transportasi.edit', compact('transportasi'));
    }

    /**
     * Perbarui data transportasi.
     */
    public function update(Request $request, Transportasi $transportasi)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'factor_emisi' => 'required|numeric|min:0',
        ]);

        $transportasi->update($validated);

        return redirect()->route('admin.transportasi.index')
            ->with('success', 'Data transportasi berhasil diperbarui.');
    }

    /**
     * Hapus data transportasi.
     */
    public function destroy(Transportasi $transportasi)
    {
        $transportasi->delete();

        return redirect()->route('admin.transportasi.index')
            ->with('success', 'Data transportasi berhasil dihapus.');
    }
}


// namespace App\Http\Controllers\Backend;

// use App\Http\Controllers\Controller;
// use App\Models\Transportasi;
// use Illuminate\Http\Request;
// ;

// class TransportasiController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index(Request $request)
//     {
//         $query = Transportasi::query();

//         if ($request->filled('kategori')) {
//             $query->where('kategori', $request->kategori);
//         }

//         if ($request->filled('search')) {
//             $query->where('jenis', 'like', '%' . $request->search . '%');
//         }

//         $transportasis = $query->latest()->paginate(10)->withQueryString();

//         return view('backend.pages.transportasi.index', compact('transportasis'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         return view('backend.pages.transportasi.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'kategori' => 'required|string|max:100',
//             'jenis' => 'required|string|max:100',
//             'factor_emisi' => 'required|numeric|min:0',
//         ]);

//         Transportasi::create($validated);

//         return redirect()->route('admin.transportasi.index')
//             ->with('success', 'Data transportasi berhasil ditambahkan.');
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Transportasi $transportasi)
//     {
//         return view('backend.pages.transportasi.edit', compact('transportasi'));
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, Transportasi $transportasi)
//     {
//         $validated = $request->validate([
//             'kategori' => 'required|string|max:255',
//             'jenis' => 'required|string|max:255',
//             'factor_emisi' => 'required|numeric|min:0',
//         ]);

//         $transportasi->update($validated);

//         return redirect()->route('admin.transportasi.index')
//             ->with('success', 'Data transportasi berhasil diperbarui.');
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Transportasi $transportasi)
//     {
//         $transportasi->delete();

//         return redirect()->route('admin.transportasi.index')
//             ->with('success', 'Data transportasi berhasil dihapus.');
//     }
// }
