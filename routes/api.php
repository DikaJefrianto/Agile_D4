<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StrategiApiController;




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

Route::apiResource('strategis', StrategiApiController::class);

// Route::get('/strategis', [StrategiApiController::class, 'index']);
// Route::post('/strategis', [StrategiApiController::class, 'store']);
// Route::put('/strategis/{id}', [StrategiApiController::class, 'update']);
// Route::delete('/strategis/{id}', [StrategiApiController::class, 'destroy']);
