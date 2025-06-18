<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['biaya.view']);
        $query = Biaya::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('jenisKendaraan', 'like', '%' . $request->search . '%');
        }

        $biayas = $query->latest()->paginate(10)->withQueryString();

        return view('backend.pages.biaya.index', compact('biayas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['biaya.create']);
        return view('backend.pages.biaya.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['biaya.create']);
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jenisKendaraan' => 'required|string|max:100',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        Biaya::create($validated);

        return redirect()->route('admin.biaya.index')
            ->with('success', 'Data biaya transportasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Biaya $biaya)
    {
        $this->checkAuthorization(auth()->user(), ['biaya.edit']);
        return view('backend.pages.biaya.edit', compact('biaya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Biaya $biaya)
    {
        $this->checkAuthorization(auth()->user(), ['biaya.edit']);
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'jenisKendaraan' => 'required|string|max:255',
            'factorEmisi' => 'required|numeric|min:0',
        ]);

        $biaya->update($validated);

        return redirect()->route('admin.biaya.index')
            ->with('success', 'Data biaya transportasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biaya $biaya)
    {
        $this->checkAuthorization(auth()->user(), ['biaya.delete']);
        $biaya->delete();

        return redirect()->route('admin.biaya.index')
            ->with('success', 'Data biaya transportasi berhasil dihapus.');
    }
}
