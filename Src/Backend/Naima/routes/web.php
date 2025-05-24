<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\perusahaan\PerusahaanController;
use App\Http\Controllers\karyawan\KaryawanController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
//  })->middleware(['auth', 'verified'])->name('dashboard');

 Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //admin route
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::resource('perusahaans', PerusahaanController::class);
        // Rute untuk perusahaan
    });
    Route::middleware(['auth','perusahaan'])->group(function () {
        Route::get('/dashboard/perusahaan', [DashboardController::class, 'perusahaan'])->name('dashboard.perusahaan');
        Route::resource('karyawans', KaryawanController::class);
    });


    // Rute untuk karyawan
    Route::middleware(['auth', 'karyawan'])->group(function () {
        Route::get('/dashboard/karyawan', [DashboardController::class, 'karyawan'])->name('dashboard.karyawan');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
//Route strategi

Route::resource('strategi', StrategiController::class);

require __DIR__.'/auth.php';
