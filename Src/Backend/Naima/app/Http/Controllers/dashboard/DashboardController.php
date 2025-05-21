<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan pengguna memiliki role
        if (!$user || !isset($user->role)) {
            abort(403, 'Tidak diizinkan');
        }

        // Redirect ke dashboard berdasarkan role
        return match ($user->role) {
            'admin' => redirect()->route('dashboard.admin'),
            'perusahaan' => redirect()->route('dashboard.perusahaan'),
            'karyawan' => redirect()->route('dashboard.karyawan'),
            default => abort(403, 'Role tidak dikenali'),
        };
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function perusahaan()
    {
        return view('dashboard.perusahaan');
    }

    public function karyawan()
    {
        return view('dashboard.karyawan');
    }
}
