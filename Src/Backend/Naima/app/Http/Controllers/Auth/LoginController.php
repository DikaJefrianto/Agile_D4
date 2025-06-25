<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
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
=======
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
>>>>>>> 67f804b1a865a6bc9e98ee724e66b9278c70b577
    }
}
