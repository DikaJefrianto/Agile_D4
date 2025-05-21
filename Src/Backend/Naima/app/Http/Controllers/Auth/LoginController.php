<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna; // Ganti dengan model pengguna Anda
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi form login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mencari user berdasarkan email
        $user = Pengguna::where('email', $request->email)->first();

        // Verifikasi password
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // Login user

            // Redirect berdasarkan role
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');  // Admin redirect ke halaman admin
            } elseif ($user->role == 'perusahaan') {
                return redirect()->route('perusahaan.dashboard');  // Perusahaan redirect ke dashboard perusahaan
            }
        }

        // Jika login gagal
        return back()->withErrors(['email' => 'Email atau password salah']);
    }
}
