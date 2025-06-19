<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BahanBakarController extends Controller
{
    /**
     * Tampilkan daftar bahan bakar dengan filter pencarian & kategori.
     */
    public function index(Request $request): View
    {
        $bahan_bakars = BahanBakar::when($request->filled('kategori'), fn($q) =>
                $q->where('kategori', $request->kategori)
            )
            ->when($request->filled('search'), fn($q) =>
                $q->where('Bahan_bakar', 'like', '%' . $request->search . '%')
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.bahan-bakar.index', compact('bahan_bakars'));
    }

    /**
     * Tampilkan form tambah bahan bakar.
     */
    public function create(): View
    {
        return view('backend.pages.bahan-bakar.create');
    }

    /**
     * Simpan data bahan bakar baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kategori' => 'required|string|max:100',
            'Bahan_bakar' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        BahanBakar::create($data);

        return redirect()->route('admin.bahan-bakar.index')
            ->with('success', 'Data bahan bakar berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail bahan bakar.
     */
    public function show(BahanBakar $bahanBakar): View
    {
        return view('backend.pages.bahan-bakar.show', compact('bahanBakar'));
    }

    /**
     * Tampilkan form edit bahan bakar.
     */
    public function edit(BahanBakar $bahanBakar): View
    {
        return view('backend.pages.bahan-bakar.edit', compact('bahanBakar'));
    }

    /**
     * Perbarui data bahan bakar.
     */
    public function update(Request $request, BahanBakar $bahanBakar): RedirectResponse
    {
        $data = $request->validate([
            'kategori' => 'required|string|max:255',
            'Bahan_bakar' => 'required|string|max:255',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $bahanBakar->update($data);

        return redirect()->route('admin.bahan-bakar.index')
            ->with('success', 'Data bahan bakar berhasil diperbarui.');
    }

    /**
     * Hapus data bahan bakar.
     */
    public function destroy(BahanBakar $bahanBakar): RedirectResponse
    {
        $bahanBakar->delete();

        return redirect()->route('admin.bahan-bakar.index')
            ->with('success', 'Data bahan bakar berhasil dihapus.');
    }
}

// namespace App\Http\Controllers\Backend;

// use App\Http\Controllers\Controller;
// use App\Models\BahanBakar;
// use Illuminate\Http\Request;

// class BahanBakarController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index(Request $request)
//     {
//         $query = BahanBakar::query();

//         if ($request->filled('kategori')) {
//             $query->where('kategori', $request->kategori);
//         }

//         if ($request->filled('search')) {
//             $query->where('Bahan_bakar', 'like', '%' . $request->search . '%');
//         }

//         $bahan_bakars = $query->latest()->paginate(10)->withQueryString();

//         return view('backend.pages.bahan-bakar.index', compact('bahan_bakars'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         return view('backend.pages.bahan-bakar.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'kategori' => 'required|string|max:100',
//             'Bahan_bakar' => 'required|string|max:100',
//             'factorEmisi' => 'required|numeric|min:0',
//         ]);

//         BahanBakar::create($validated);

//         return redirect()->route('admin.bahan-bakar.index')
//             ->with('success', 'Data bahan bakar berhasil ditambahkan.');
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(BahanBakar $bahanBakar)
//     {
//         return view('backend.pages.bahan-bakar.show', compact('bahanBakar'));
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(BahanBakar $bahanBakar)
//     {
//         return view('backend.pages.bahan-bakar.edit', compact('bahanBakar'));
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, BahanBakar $bahanBakar)
//     {
//         $validated = $request->validate([
//             'kategori' => 'required|string|max:255',
//             'Bahan_bakar' => 'required|string|max:255',
//             'factorEmisi' => 'required|numeric|min:0',
//         ]);

//         $bahanBakar->update($validated);

//         return redirect()->route('admin.bahan-bakar.index')
//             ->with('success', 'Data bahan bakar berhasil diperbarui.');
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(BahanBakar $bahanBakar)
//     {
//         $bahanBakar->delete();

//         return redirect()->route('admin.bahan-bakar.index')
//             ->with('success', 'Data bahan bakar berhasil dihapus.');
//     }
// }
