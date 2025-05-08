<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\perusahaan\PerusahaanController;
use App\Http\Controllers\pengguna\PenggunaController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Menggunakan Route Resource untuk controller PerusahaanController
Route::resource('perusahaans', PerusahaanController::class);

Route::resource('penggunas', PenggunaController::class);



// Menampilkan form login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('login', [LoginController::class, 'login'])->name('login.submit');

// Halaman setelah login untuk pengguna yang sudah terautentikasi
Route::middleware('auth')->group(function () {
    // Halaman dashboard perusahaan
    Route::get('perusahaan/dashboard', [PerusahaanController::class, 'dashboard'])->name('perusahaan.dashboard');
    // Halaman dashboard admin (Naima)
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});


