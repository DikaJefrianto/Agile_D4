<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use Illuminate\Http\Request;

class BahanBakarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.view']);
        $query = BahanBakar::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('Bahan_bakar', 'like', '%' . $request->search . '%');
        }

        $bahan_bakars = $query->latest()->paginate(10)->withQueryString();

        return view('backend.pages.bahan-bakar.index', compact('bahan_bakars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.create']);
        return view('backend.pages.bahan-bakar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.create']);
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'Bahan_bakar' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        BahanBakar::create($validated);

        return redirect()->route('admin.bahan-bakar.index')
            ->with('success', 'Data bahan bakar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanBakar $bahanBakar)
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.view']);
        return view('backend.pages.bahan-bakar.show', compact('bahanBakar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanBakar $bahanBakar)
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.edit']);
        return view('backend.pages.bahan-bakar.edit', compact('bahanBakar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBakar $bahanBakar)
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.edit']);
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'Bahan_bakar' => 'required|string|max:255',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $bahanBakar->update($validated);

        return redirect()->route('admin.bahan-bakar.index')
            ->with('success', 'Data bahan bakar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBakar $bahanBakar)
    {
        $this->checkAuthorization(auth()->user(), ['bahanbakar.delete']);
        $bahanBakar->delete();

        return redirect()->route('admin.bahan-bakar.index')
            ->with('success', 'Data bahan bakar berhasil dihapus.');
    }
}
