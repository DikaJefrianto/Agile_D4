<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\BahanBakarController;

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');

// Route::get('/perhitungan/create', [PerhitunganController::class, 'create'])->name('perhitungan.create');

// Route::post('/perhitungan', [PerhitunganController::class, 'store'])->name('perhitungan.store');

use App\Http\Controllers\DashboardController;

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Route::resource('perhitungan', PerhitunganController::class);
// Route::resource('konsultasi', KonsultasiController::class);
// Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');
// Route::get('/login', function () {
//     return 'Halaman login belum dibuat';
// })->name('login');

Route::get('perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
Route::get('perhitungan/create', [PerhitunganController::class, 'create'])->name('perhitungan.create');
Route::post('perhitungan', [PerhitunganController::class, 'store'])->name('perhitungan.store');
Route::get('perhitungan/{id}/edit', [PerhitunganController::class, 'edit'])->name('perhitungan.edit');
Route::put('perhitungan/{id}', [PerhitunganController::class, 'update'])->name('perhitungan.update');
Route::delete('perhitungan/{id}', [PerhitunganController::class, 'destroy'])->name('perhitungan.destroy');

// Tampilkan form dan hasil (jika ada)
Route::get('perhitungan/hitung', [PerhitunganController::class, 'hitungForm'])->name('perhitungan.hitungForm');

// Proses perhitungan
Route::post('perhitungan/hitung', [PerhitunganController::class, 'hitungEmisi'])->name('perhitungan.hitungEmisi');

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

Route::get('konsultasi', [BahanBakarController::class, 'index'])->name('Konsultasi.index');