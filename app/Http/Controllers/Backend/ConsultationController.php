<?php

// app/Http/Controllers/ConsultationController.php

namespace App\Http\Controllers\Backend;

use App\Models\Perusahaan;
use App\Models\Karyawan;
use App\Models\Strategi;
use App\Models\BahanBakar;
use App\Models\Kendaraan;
use App\Models\Feedback;
use App\Models\PerjalananDinas;
use App\Models\Perhitungan;
use App\Models\Consultations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    // Perusahaan - Lihat semua konsultasi
    public function index()
    {
        $consultations = Consultation::where('perusahaan_id', Auth::user()->company_id)->latest()->paginate(10);
        return view('backend.pages.konsultasi.index', compact('consultations'));
    }

    // Perusahaan - Form ajukan konsultasi
    public function create()
    {
        return view('backend.pages.konsultasi.create');
    }

    // Perusahaan - Simpan pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'requested_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        Consultation::create([
            'perusahaan_id' => Auth::user()->perusahaan_id,
            'requested_date' => $request->requested_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.consultations.index')->with('success', 'Pengajuan konsultasi berhasil dikirim.');
    }

    // Admin - Lihat semua konsultasi
    public function adminIndex()
    {
        $consultations = Consultation::with('company')->latest()->get();
        return view('admin.consultations.index', compact('consultations'));
    }

    // Admin - Edit konsultasi
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('admin.consultations.edit', compact('consultation'));
    }

    // Admin - Update status/jadwal
    public function update(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'confirmed_date' => 'nullable|date',
            'meeting_location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $consultation->update([
            'status' => $request->status,
            'confirmed_date' => $request->confirmed_date,
            'meeting_location' => $request->meeting_location,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.consultations.index')->with('success', 'Konsultasi berhasil diperbarui.');
    }
}

