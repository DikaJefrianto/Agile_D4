<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\Strategi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;


class StrategiController extends Controller
{
    /**
     * Display a listing of the strategi.
     */
    public function index(): Renderable
{
    $this->checkAuthorization(auth()->user(), ['strategi.view']);

    $query = Strategi::with('perusahaan')->latest();

    if (auth()->user()->role === 'perusahaan') {
        $query->where('perusahaan_id', auth()->user()->perusahaan->id);
    }

    $strategis = $query->paginate(10);

    return view('backend.pages.strategis.index', compact('strategis'));
}


    /**
     * Show the form for creating a new strategi.
     */
    public function create(): Renderable
    {
        // No authentication. All companies are available for selection.
        $this->checkAuthorization(auth()->user(), ['strategi.create']);

        $perusahaans = Perusahaan::all(); // This line gets all companies

        return view('backend.pages.strategis.create', compact('perusahaans'));
    }

    /**
     * Store a newly created strategi in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // No authentication. Validation applies to all input.
        $validatedData = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            // Since no roles, 'perusahaan_id' must always be provided
            'perusahaan_id' => 'required|exists:perusahaans,id',
        ]);

        // With no authenticated user or roles, perusahaan_id must come from the request
        $perusahaanId = (int) $request->input('perusahaan_id');

        if ($request->hasFile('dokumen')) {
            $validatedData['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');
        } else {
            $validatedData['dokumen'] = null;
        }

        Strategi::create([
            'perusahaan_id' => $perusahaanId,
            'nama_program' => $validatedData['nama_program'],
            'deskripsi' => $validatedData['deskripsi'],
            'status' => $validatedData['status'],
            'dokumen' => $validatedData['dokumen'],
        ]);

        return redirect()->route('admin.strategis.index')->with('success', 'Strategy successfully added.');
    }

    /**
     * Display the specified strategi.
     */
    public function show(Strategi $strategi): Renderable
    {
        // No authentication. Any strategy can be viewed.
        return view('backend.pages.strategis.show', compact('strategi'));
    }

    /**
     * Show the form for editing the specified strategi.
     */
    public function edit(Strategi $strategi): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['strategi.edit']);
        // No authentication. All companies are available for selection.
        $perusahaans = Perusahaan::all();
        return view('backend.pages.strategis.edit', compact('strategi', 'perusahaans'));
    }

    /**
     * Update the specified strategi in storage.
     */
    // public function update(Request $request, Strategi $strategi): RedirectResponse
    // {
    //     // No authentication. Validation applies to all input.
    //     $validationRules = [
    //         'nama_program' => 'required|string|max:255',
    //         'deskripsi' => 'nullable|string',
    //         'status' => 'required|in:aktif,nonaktif',
    //         'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    //         // With no roles, 'perusahaan_id' must always be provided for updates as well
    //         'perusahaan_id' => 'required|exists:perusahaans,id',
    //     ];

    //     $validatedData = $request->validate($validationRules);

    //     // Handle document upload
    //     if ($request->hasFile('dokumen')) {
    //         // Delete old document if it exists
    //         if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
    //             Storage::disk('public')->delete($strategi->dokumen);
    //         }
    //         $validatedData['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');
    //     } else if ($request->boolean('remove_dokumen')) { // Option to remove document
    //         if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
    //             Storage::disk('public')->delete($strategi->dokumen);
    //         }
    //         $validatedData['dokumen'] = null;
    //     }

    //     // Always set perusahaan_id from validated data since there are no roles
    //     $strategi->perusahaan_id = $validatedData['perusahaan_id'];


    //     $strategi->fill([
    //         'nama_program' => $validatedData['nama_program'],
    //         'deskripsi' => $validatedData['deskripsi'],
    //         'status' => $validatedData['status'],
    //         'dokumen' => $validatedData['dokumen'] ?? $strategi->dokumen, // Keep existing if no new upload and not removed
    //     ])->save();

    //     return redirect()->route('admin.strategis.index')->with('success', 'Strategy successfully updated.');
    // }


    //refactoring
    public function update(Request $request, Strategi $strategi): RedirectResponse
    {
        $validated = $request->validate([
            'nama_program'   => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'status'         => 'required|in:aktif,nonaktif',
            'dokumen'        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'perusahaan_id'  => 'required|exists:perusahaans,id',
            'remove_dokumen' => 'nullable|boolean',
        ]);

        // Handle dokumen upload or removal
        if ($request->hasFile('dokumen')) {
            if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
                Storage::disk('public')->delete($strategi->dokumen);
            }
            $validated['dokumen'] = $request->file('dokumen')->store('strategi_docs', 'public');
        } elseif ($request->boolean('remove_dokumen') && $strategi->dokumen) {
            if (Storage::disk('public')->exists($strategi->dokumen)) {
                Storage::disk('public')->delete($strategi->dokumen);
            }
            $validated['dokumen'] = null;
        } else {
            $validated['dokumen'] = $strategi->dokumen;
        }

        $strategi->update([
            'perusahaan_id' => $validated['perusahaan_id'],
            'nama_program'  => $validated['nama_program'],
            'deskripsi'     => $validated['deskripsi'],
            'status'        => $validated['status'],
            'dokumen'       => $validated['dokumen'],
        ]);

        return redirect()->route('admin.strategis.index')->with('success', 'Strategy successfully updated.');
    }


    /**
     * Remove the specified strategi from storage.
     */
    public function destroy(Strategi $strategi): RedirectResponse
    {
        // No authentication. Any strategy can be deleted.

        // Delete associated document if it exists
        if ($strategi->dokumen && Storage::disk('public')->exists($strategi->dokumen)) {
            Storage::disk('public')->delete($strategi->dokumen);
        }

        $strategi->delete();

        return redirect()->route('admin.strategis.index')->with('success', 'Strategy successfully deleted.');
    }

    // Removed: private function resolvePerusahaanId(...) as roles are no longer considered for this logic.
}
