<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PerusahaanController;

// Route manual untuk API Perusahaan
Route::get('/perusahaans', [PerusahaanController::class, 'index']); // Menampilkan semua data
Route::post('/perusahaans', [PerusahaanController::class, 'store']); // Menambahkan data baru
Route::get('/perusahaans/{id}', [PerusahaanController::class, 'show']); // Menampilkan detail data berdasarkan ID
Route::put('/perusahaans/{id}', [PerusahaanController::class, 'update']); // Memperbarui data berdasarkan ID
Route::delete('/perusahaans/{id}', [PerusahaanController::class, 'destroy']); // Menghapus data berdasarkan ID
