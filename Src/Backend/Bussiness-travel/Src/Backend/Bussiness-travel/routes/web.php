<?php

declare (strict_types = 1);

use App\Http\Controllers\Backend\ActionLogController;
use App\Http\Controllers\Backend\BahanBakarController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FeedbackController;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\KendaraanController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\ModulesController;
use App\Http\Controllers\Backend\PerhitunganController;
use App\Http\Controllers\Backend\PerjalananDinasController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\PerusahaanController;
use App\Http\Controllers\Backend\ProfilesController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\StrategiController;
use App\Http\Controllers\Backend\TranslationController;
use App\Http\Controllers\Backend\UserLoginAsController;
use App\Http\Controllers\Backend\UsersController;use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Dashboard routes based on roles
 */
Route::middleware(['auth', 'role:superadmin|admin'])
    ->prefix('dashboard')->as('admin.')
    ->group(function () {
        // …
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
        // …
        // Route::middleware(['auth'])->prefix('dashboard')->group(function ()

        // Admin / Super Admin

        Route::middleware(['role:admin|superadmin'])->group(function () {
        });
        // Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.admin');

        Route::resource('roles', RolesController::class);
        Route::resource('perusahaans', PerusahaanController::class);

        // Permissions
        Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/{id}', [PermissionsController::class, 'show'])->name('permissions.show');

        // Modules
        Route::get('/modules', [ModulesController::class, 'index'])->name('modules.index');
        Route::post('/modules/toggle-status/{module}', [ModulesController::class, 'toggleStatus'])->name('modules.toggle-status');
        Route::post('/modules/upload', [ModulesController::class, 'upload'])->name('modules.upload');
        Route::delete('/modules/{module}', [ModulesController::class, 'destroy'])->name('modules.delete');

        // Perusahaan
        Route::middleware(['role:perusahaan'])->group(function () {
            Route::get('/perusahaan', fn() => view('dashboard.perusahaan'))->name('dashboard.perusahaan');
            Route::resource('karyawans', KaryawanController::class);
            // Tambahkan route khusus perusahaan jika diperlukan di sini
        });

        // Karyawan
        Route::middleware(['role:karyawan'])->group(function () {
            Route::get('/karyawan', fn() => view('dashboard.karyawan'))->name('dashboard.karyawan');
            // Tambahkan route khusus karyawan jika diperlukan di sini
        });

        // Umum untuk semua role (auth)
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

        Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
        Route::post('/translations/create', [TranslationController::class, 'create'])->name('translations.create');

        Route::resource('users', UsersController::class);
        Route::get('users/{id}/login-as', [UserLoginAsController::class, 'loginAs'])->name('users.login-as');
        Route::post('users/switch-back', [UserLoginAsController::class, 'switchBack'])->name('users.switch-back');

        Route::get('/action-log', [ActionLogController::class, 'index'])->name('actionlog.index');

        Route::resource('strategis', StrategiController::class);
        Route::resource('bahan-bakars', BahanBakarController::class);
        Route::resource('kendaraans', KendaraanController::class);
        Route::resource('feedbacks', FeedbackController::class);
        Route::resource('perjalanan-dinas', PerjalananDinasController::class);
        Route::resource('perhitungans', PerhitunganController::class);

    });

/**
 * Profile routes.
 */
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('/edit', [ProfilesController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfilesController::class, 'update'])->name('update');
});

Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');
