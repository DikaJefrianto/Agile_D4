<?php

namespace App\Http\Controllers\Backend;

use App\Models\Perusahaan;
use App\Models\Karyawan;
use App\Models\Strategi;
use App\Models\BahanBakar;
use App\Models\Kendaraan;
use App\Models\Feedback;
use App\Models\PerjalananDinas;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user')->get();
        return view('backend.pages.feedbacks.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('backend.pages.feedbacks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // 'user_id' => 'nullable|exists:users,id',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Feedback::create($data);
        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback berhasil ditambahkan.');
    }

    public function show(Feedback $feedback)
    {
        return view('backend.pages.feedbacks.show', compact('feedback'));
    }

    public function edit(Feedback $feedback)
    {
        return view('backend.pages.feedbacks.edit', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $feedback->update($data);
        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback berhasil diperbarui.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
