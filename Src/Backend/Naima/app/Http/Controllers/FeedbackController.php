<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin melihat semua feedback
            $feedbacks = Feedback::with('user')->latest()->get();
        } else {
            // Pengguna hanya melihat feedback miliknya
            $feedbacks = Feedback::where('user_id', $user->id)->latest()->get();
        }

        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Feedback::create([
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        $this->authorizeAccess($feedback);

        return view('feedbacks.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        $this->authorizeAccess($feedback);

        $request->validate([
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $feedback->update([
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $this->authorizeAccess($feedback);

        $feedback->delete();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dihapus.');
    }

    /**
     * Cek apakah pengguna berhak mengakses feedback ini.
     */
    private function authorizeAccess(Feedback $feedback)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $feedback->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }
}
