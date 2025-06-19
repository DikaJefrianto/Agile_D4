<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BiayaController extends Controller
{
    /**
     * Menampilkan daftar data biaya dengan filter kategori dan pencarian.
     */
    public function index(Request $request): View
    {
        $biayas = Biaya::when($request->filled('kategori'), fn ($q) =>
                    $q->where('kategori', $request->kategori))
                ->when($request->filled('search'), fn ($q) =>
                    $q->where('jenisKendaraan', 'like', '%' . $request->search . '%'))
                ->latest()
                ->paginate(10)
                ->withQueryString();

        return view('backend.pages.biaya.index', compact('biayas'));
    }

    /**
     * Menampilkan form tambah data biaya.
     */
    public function create(): View
    {
        return view('backend.pages.biaya.create');
    }

    /**
     * Menyimpan data biaya baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kategori' => 'required|string|max:100',
            'jenisKendaraan' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        Biaya::create($data);

        return redirect()->route('admin.biaya.index')
            ->with('success', 'Data biaya transportasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data biaya.
     */
    public function edit(Biaya $biaya): View
    {
        return view('backend.pages.biaya.edit', compact('biaya'));
    }

    /**
     * Memperbarui data biaya yang sudah ada.
     */
    public function update(Request $request, Biaya $biaya): RedirectResponse
    {
        $data = $request->validate([
            'kategori' => 'required|string|max:255',
            'jenisKendaraan' => 'required|string|max:255',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $biaya->update($data);

        return redirect()->route('admin.biaya.index')
            ->with('success', 'Data biaya transportasi berhasil diperbarui.');
    }

    /**
     * Menghapus data biaya.
     */
    public function destroy(Biaya $biaya): RedirectResponse
    {
        $biaya->delete();

        return redirect()->route('admin.biaya.index')
            ->with('success', 'Data biaya transportasi berhasil dihapus.');
    }
}

// namespace App\Http\Controllers\Backend;

// use App\Http\Controllers\Controller;
// use App\Models\Biaya;
// use Illuminate\Http\Request;

// class BiayaController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index(Request $request)
//     {
//         $query = Biaya::query();

//         if ($request->filled('kategori')) {
//             $query->where('kategori', $request->kategori);
//         }

//         if ($request->filled('search')) {
//             $query->where('jenisKendaraan', 'like', '%' . $request->search . '%');
//         }

//         $biayas = $query->latest()->paginate(10)->withQueryString();

//         return view('backend.pages.biaya.index', compact('biayas'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         return view('backend.pages.biaya.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'kategori' => 'required|string|max:100',
//             'jenisKendaraan' => 'required|string|max:100',
//             'factorEmisi' => 'required|numeric|min:0',
//         ]);

//         Biaya::create($validated);

//         return redirect()->route('admin.biaya.index')
//             ->with('success', 'Data biaya transportasi berhasil ditambahkan.');
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Biaya $biaya)
//     {
//         return view('backend.pages.biaya.edit', compact('biaya'));
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, Biaya $biaya)
//     {
//         $validated = $request->validate([
//             'kategori' => 'required|string|max:255',
//             'jenisKendaraan' => 'required|string|max:255',
//             'factorEmisi' => 'required|numeric|min:0',
//         ]);

//         $biaya->update($validated);

//         return redirect()->route('admin.biaya.index')
//             ->with('success', 'Data biaya transportasi berhasil diperbarui.');
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Biaya $biaya)
//     {
//         $biaya->delete();

//         return redirect()->route('admin.biaya.index')
//             ->with('success', 'Data biaya transportasi berhasil dihapus.');
//     }
// }
