<?php

use App\Http\Controllers\Api\BahanBakarApiController;
use App\Http\Controllers\Api\BiayaApiController;
use App\Http\Controllers\Api\TransportasiApiController;
use App\Http\Controllers\Backend\BahanBakarController;
use App\Http\Controllers\Backend\BiayaController;
use App\Http\Controllers\Backend\TransportasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API endpoint to get translations for a specific language
Route::get('/translations/{lang}', function (string $lang) {
    $path = resource_path("lang/{$lang}.json");

    if (!file_exists($path)) {
        return response()->json(['error' => 'Language not found'], 404);
    }

    $translations = json_decode(file_get_contents($path), true);
    return response()->json($translations);
});
Route::prefix('bahan-bakar')->group(function () {
    Route::get('/', [BahanBakarApiController::class, 'index']);        // GET semua data
    Route::get('{id}', [BahanBakarApiController::class, 'show']);      // GET detail by ID
    Route::post('/', [BahanBakarApiController::class, 'store']);       // POST tambah data
    Route::put('{id}', [BahanBakarApiController::class, 'update']);    // PUT update data
    Route::delete('{id}', [BahanBakarApiController::class, 'destroy']); // DELETE data
});
Route::prefix('transportasi')->group(function () {
    Route::get('/', [TransportasiApiController::class, 'index']);        // GET semua data
    Route::get('{id}', [TransportasiApiController::class, 'show']);      // GET detail by ID
    Route::post('/', [TransportasiApiController::class, 'Store']);       // POST tambah data
    Route::put('{id}', [TransportasiApiController::class, 'update']);    // PUT update data
    Route::delete('{id}', [TransportasiApiController::class, 'destroy']); // DELETE data
});
Route::prefix('biaya')->group(function () {
    Route::get('/', [BiayaApiController::class, 'index']);        // GET semua data
    Route::get('{id}', [BiayaApiController::class, 'show']);      // GET detail by ID
    Route::post('/', [BiayaApiController::class, 'store']);       // POST tambah data
    Route::put('{id}', [BiayaApiController::class, 'update']);    // PUT update data
    Route::delete('{id}', [BiayaApiController::class, 'destroy']); // DELETE data
});