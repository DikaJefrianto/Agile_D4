<?php
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\PerusahaanController;
use Illuminate\Support\Facades\Route;

// Route manual untuk API Perusahaan
Route::get('/perusahaans', [PerusahaanController::class, 'index']);           // Menampilkan semua data
Route::post('/perusahaans', [PerusahaanController::class, 'store']);          // Menambahkan data baru
Route::get('/detailperusahaans/{id}', [PerusahaanController::class, 'show']);       // Menampilkan detail data berdasarkan ID
Route::put('/editperusahaans/{id}', [PerusahaanController::class, 'update']);     // Memperbarui data berdasarkan ID
Route::delete('/deleteperusahaans/{id}', [PerusahaanController::class, 'destroy']); // Menghapus data berdasarkan ID

Route::get('/karyawans', [KaryawanController::class, 'index']);           // Menampilkan semua data
Route::post('/karyawans', [KaryawanController::class, 'store']);          // Menambahkan data baru
Route::get('/detailkaryawans/{id}', [KaryawanController::class, 'show']);       // Menampilkan detail data berdasarkan ID
Route::put('/editkaryawans/{id}', [KaryawanController::class, 'update']);     // Memperbarui data berdasarkan ID
Route::delete('/deletekaryawans/{id}', [KaryawanController::class, 'destroy']); // Menghapus data berdasarkan ID
