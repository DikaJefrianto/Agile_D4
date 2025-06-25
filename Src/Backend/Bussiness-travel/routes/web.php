<?php

declare (strict_types = 1);

use App\Http\Controllers\Backend\ActionLogController;
<<<<<<< HEAD
use App\Http\Controllers\Backend\BahanBakarController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FeedbackController;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\KendaraanController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\ModulesController;
use App\Http\Controllers\Backend\PerhitunganController;
use App\Http\Controllers\Backend\PerjalananDinasController;
=======

use App\Http\Controllers\Backend\BahanBakarController;

use App\Http\Controllers\Backend\BiayaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HasilPerhitunganController;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\KonsultasiController;
use App\Http\Controllers\Backend\LaporanController;;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\ModulesController;
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\PerusahaanController;
use App\Http\Controllers\Backend\ProfilesController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\StrategiController;
use App\Http\Controllers\Backend\TranslationController;
<<<<<<< HEAD
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
=======
use App\Http\Controllers\Backend\TransportasiController;
use App\Http\Controllers\Backend\UserLoginAsController;
use App\Http\Controllers\Backend\UsersController;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about_us', function () {
    return view('about_us');
})->name('about_us');

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
            Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
            Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.exportCsv');
            Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
            Route::get('/laporan/{perusahaan}/detail', [LaporanController::class, 'showDetail'])->name('laporan.detail');
            Route::get('/laporan/{perusahaan}/detail/export-pdf', [LaporanController::class, 'exportDetailPdf'])->name('laporan.detail.exportPdf');
            Route::get('/laporan/{perusahaan}/detail/export-csv', [LaporanController::class, 'exportDetailCsv'])->name('laporan.detail.exportCsv');
            Route::get('/laporan/{perusahaan}/detail/export-excel', [LaporanController::class, 'exportDetailExcel'])->name('laporan.detail.exportExcel');
            Route::resources([
                'bahan-bakar'  => BahanBakarController::class,
                'transportasi' => TransportasiController::class,
                'perhitungan'  => HasilPerhitunganController::class,
                'biaya'        => BiayaController::class,
                'strategis'    => StrategiController::class,
                'perusahaans'  => PerusahaanController::class,
                'karyawans'    => KaryawanController::class,
                'roles'        => RolesController::class,
                'users'        => UsersController::class,
                'laporan'      => LaporanController::class,
            ]);

            Route::resource('konsultasis', KonsultasiController::class);

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
            Route::get('/pehitungan', [HasilPerhitunganController::class, 'index'])->name('perhitungan.index');
            Route::post('/perhitungan', [HasilPerhitunganController::class, 'store'])->name('perhitungan.store');
            Route::get('/perhitungan/{id}', [HasilPerhitunganController::class, 'show'])->name('perhitungan.show');
            Route::put('/perhitungan/{id}', [HasilPerhitunganController::class, 'update'])->name('perhitungan.update');
        });

        /**
     * Karyawan only
     */
        Route::middleware(['role:karyawan'])->group(function () {
            Route::get('/karyawan', fn() => view('dashboard.karyawan'))->name('dashboard.karyawan');
            // Tambahkan route lain untuk karyawan di sini jika perlu
            Route::resources(['perhitungan'  => HasilPerhitunganController::class,]);
        });

        /**
     * Shared by all authenticated roles (admin, perusahaan, karyawan)
     */
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

        Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
        Route::post('/translations/create', [TranslationController::class, 'create'])->name('translations.create');
<<<<<<< HEAD

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

=======
    });

//Route untuk strategi
Route::middleware(['role:admin|superadmin'])
    ->resource('strategis', StrategiController::class)
    ->except(['index', 'show']);

// Strategi - Perusahaan & Karyawan hanya bisa lihat
Route::middleware(['role:perusahaan|karyawan'])
    ->prefix('strategis')
    ->name('strategis.')
    ->group(function () {
        Route::get('/', [StrategiController::class, 'index'])->name('index');
        Route::get('/{strategi}', [StrategiController::class, 'show'])->name('show');
    });
//Route konsultasi
Route::middleware(['role:perusahaan'])->group(function () {
    // Perusahaan/Karyawan bisa melihat daftar konsultasi mereka
    Route::get('/konsultasis', [KonsultasiController::class, 'index'])->name('konsultasis.index');
    // Perusahaan/Karyawan bisa melihat detail konsultasi mereka
    Route::get('/konsultasis/{konsultasi}', [KonsultasiController::class, 'show'])->name('konsultasis.show');
    // Perusahaan/Karyawan bisa mengajukan konsultasi baru (form dan store)
    Route::get('/konsultasis/create', [KonsultasiController::class, 'create'])->name('konsultasis.create');
    Route::post('/konsultasis', [KonsultasiController::class, 'store'])->name('konsultasis.store');
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
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');
