<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\perusahaan\PerusahaanController;

Route::get('/', function () {
    return view('welcome');
});

// Menggunakan Route Resource untuk controller PerusahaanController
Route::resource('perusahaans', PerusahaanController::class);

