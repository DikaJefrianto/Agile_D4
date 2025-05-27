<?php

use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\karyawan\KaryawanController;
use App\Http\Controllers\perusahaan\PerusahaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\BahanBakarController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\HasilPerhitunganController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\strategi\StrategiController;
use Illuminate\Support\Facades\Route;

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
        Route::get('perhitungan', [HasilPerhitunganController::class, 'index'])->name('perhitungan.index');
        Route::get('perhitungan/create', [HasilPerhitunganController::class, 'create'])->name('perhitungan.create');
        Route::post('perhitungan', [HasilPerhitunganController::class, 'store'])->name('perhitungan.store');
        Route::get('perhitungan/{id}/edit', [HasilPerhitunganController::class, 'edit'])->name('perhitungan.edit');
        Route::put('perhitungan/{id}', [HasilPerhitunganController::class, 'update'])->name('perhitungan.update');
        Route::delete('perhitungan/{id}', [HasilPerhitunganController::class, 'destroy'])->name('perhitungan.destroy');
        Route::get('/transportasi', [TransportasiController::class, 'index'])->name('transportasi.index');

        Route::get('transportasi', [TransportasiController::class, 'index'])->name('transportasi.index');
        Route::get('transportasi/create', [TransportasiController::class, 'create'])->name('transportasi.create');
        Route::post('transportasi', [TransportasiController::class, 'store'])->name('transportasi.store');
        Route::get('transportasi/{id}/edit', [TransportasiController::class, 'edit'])->name('transportasi.edit');
        Route::put('transportasi/{id}', [TransportasiController::class, 'update'])->name('transportasi.update');
        Route::delete('transportasi/{id}', [TransportasiController::class, 'destroy'])->name('transportasi.destroy');

        Route::get('BahanBakar', [BahanBakarController::class, 'index'])->name('BahanBakar.index');
        Route::get('BahanBakar/create', [BahanBakarController::class, 'create'])->name('BahanBakar.create');
        Route::post('BahanBakar', [BahanBakarController::class, 'store'])->name('BahanBakar.store');
        Route::get('BahanBakar/{id}/edit', [BahanBakarController::class, 'edit'])->name('BahanBakar.edit');
        Route::put('BahanBakar/{id}', [BahanBakarController::class, 'update'])->name('BahanBakar.update');
        Route::delete('BahanBakar/{id}', [BahanBakarController::class, 'destroy'])->name('BahanBakar.destroy');

        Route::get('biaya', [BiayaController::class, 'index'])->name('biaya.index');
        Route::get('biaya/create', [BiayaController::class, 'create'])->name('biaya.create');
        Route::post('biaya', [BiayaController::class, 'store'])->name('biaya.store');
        Route::get('biaya/{id}/edit', [BiayaController::class, 'edit'])->name('biaya.edit');
        Route::put('biaya/{id}', [BiayaController::class, 'update'])->name('biaya.update');
        Route::delete('biaya/{id}', [BiayaController::class, 'destroy'])->name('biaya.destroy');

        // Rute untuk perusahaan
    });
    Route::middleware(['auth', 'perusahaan'])->group(function () {
        Route::get('/dashboard/perusahaan', [DashboardController::class, 'perusahaan'])->name('dashboard.perusahaan');
        Route::resource('karyawans', KaryawanController::class);
    });

    // Rute untuk karyawan
    Route::middleware(['auth', 'karyawan'])->group(function () {
        Route::get('/dashboard/karyawan', [DashboardController::class, 'karyawan'])->name('dashboard.karyawan');
        Route::get('perhitungan', [HasilPerhitunganController::class, 'index'])->name('perhitungan.index');
        Route::get('perhitungan/create', [HasilPerhitunganController::class, 'create'])->name('perhitungan.create');
        Route::post('perhitungan', [HasilPerhitunganController::class, 'store'])->name('perhitungan.store');

    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
//Route strategi

Route::resource('strategi', StrategiController::class);

require __DIR__ . '/auth.php';
