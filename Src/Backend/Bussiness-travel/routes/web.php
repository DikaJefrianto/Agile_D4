<?php

declare (strict_types = 1);

use App\Http\Controllers\Backend\ActionLogController;

use App\Http\Controllers\Backend\BahanBakarController;
use App\Http\Controllers\Backend\BiayaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HasilPerhitunganController;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\LaporanController; // Pastikan ini di-import
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\ModulesController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\PerusahaanController;
use App\Http\Controllers\Backend\ProfilesController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\StrategiController;
use App\Http\Controllers\Backend\TranslationController;
use App\Http\Controllers\Backend\TransportasiController;
use App\Http\Controllers\Backend\UserLoginAsController;
use App\Http\Controllers\Backend\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Auth routes
Auth::routes(['verify' => true]);

// Dashboard (all authenticated users can access this prefix)
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')->as('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        /**
        * Admin / Superadmin routes only
        */
        Route::middleware(['role:admin|superadmin'])->group(function () {
            // PENTING: Pindahkan rute spesifik 'laporan/export-pdf' dan 'laporan/export-csv'
            // DI ATAS deklarasi Route::resources untuk 'laporan'.
            Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
            Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.exportCsv');
            Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
            Route::get('/laporan/{perusahaan}/detail', [LaporanController::class, 'showDetail'])->name('laporan.detail');
            Route::get('/laporan/{perusahaan}/detail/export-pdf', [LaporanController::class, 'exportDetailPdf'])->name('laporan.detail.exportPdf');
            Route::get('/laporan/{perusahaan}/detail/export-csv', [LaporanController::class, 'exportDetailCsv'])->name('laporan.detail.exportCsv');
            Route::get('/laporan/{perusahaan}/detail/export-excel', [LaporanController::class, 'exportDetailExcel'])->name('laporan.detail.exportExcel');
            Route::resources([
                'bahan-bakar'   => BahanBakarController::class,
                'transportasi'  => TransportasiController::class,
                'perhitungan'   => HasilPerhitunganController::class,
                'biaya'         => BiayaController::class,
                'strategis'     => StrategiController::class,
                'perusahaans'   => PerusahaanController::class,
                'karyawans'     => KaryawanController::class,
                'roles'         => RolesController::class,
                'users'         => UsersController::class,
                'laporan'       => LaporanController::class, // Ini akan membuat rute 'laporan.index', dll.
            ]);

            // Perbaikan penamaan rute. Karena sudah di dalam group 'admin.',
            // nama rute sudah otomatis 'admin.laporan.exportPdf'.
            // Jadi, cukup gunakan 'laporan.exportPdf' dan 'laporan.exportCsv' seperti yang ada di atas.
            // Baris-baris di bawah ini sekarang REDUNDANT dan dihapus.
            // Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.exportPdf');
            // Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('admin.laporan.exportCsv');


            Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
            Route::get('/permissions/{id}', [PermissionsController::class, 'show'])->name('permissions.show');

            Route::get('/modules', [ModulesController::class, 'index'])->name('modules.index');
            Route::post('/modules/upload', [ModulesController::class, 'upload'])->name('modules.upload');
            Route::post('/modules/toggle-status/{module}', [ModulesController::class, 'toggleStatus'])->name('modules.toggle-status');
            Route::delete('/modules/{module}', [ModulesController::class, 'destroy'])->name('modules.delete');

            Route::get('users/{id}/login-as', [UserLoginAsController::class, 'loginAs'])->name('users.login-as');
            Route::post('users/switch-back', [UserLoginAsController::class, 'switchBack'])->name('users.switch-back');

            Route::get('/action-log', [ActionLogController::class, 'index'])->name('actionlog.index');
        });

        /**
        * Perusahaan only
        */
        Route::middleware(['role:perusahaan'])->group(function () {
            Route::get('/perusahaan', fn() => view('dashboard.perusahaan'))->name('dashboard.perusahaan');
            // Tambahkan route lain untuk perusahaan di sini jika perlu
        });

        /**
        * Karyawan only
        */
        Route::middleware(['role:karyawan'])->group(function () {
            Route::get('/karyawan', fn() => view('dashboard.karyawan'))->name('dashboard.karyawan');
            // Tambahkan route lain untuk karyawan di sini jika perlu
        });

        /**
        * Shared by all authenticated roles (admin, perusahaan, karyawan)
        */
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

        Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
        Route::post('/translations/create', [TranslationController::class, 'create'])->name('translations.create');
    });

/**
 * Profile routes (untuk semua user login)
 */
Route::middleware('auth')
    ->prefix('profile')->as('profile.')
    ->group(function () {
        Route::get('/edit', [ProfilesController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfilesController::class, 'update'])->name('update');
    });

/**
 * Locale switcher
 */
Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');
