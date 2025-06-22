<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Backend\{
    ActionLogController,
    BahanBakarController,
    BiayaController,
    DashboardController,
    FeedbackController,
    HasilPerhitunganController,
    KaryawanController,
    TransportasiController,
    LocaleController,
    ModulesController,
    PerjalananDinasController,
    PermissionsController,
    PerusahaanController,
    ProfilesController,
    RolesController,
    SettingsController,
    StrategiController,
    TranslationController,
    UserLoginAsController,
    UsersController,
    KonsultasiController
};

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
            Route::resources([
                'bahan-bakar' => BahanBakarController::class,
                'transportasi' => TransportasiController::class,
                'perhitungan' => HasilPerhitunganController::class,
                'biaya'        => BiayaController::class,
                'strategis'    => StrategiController::class,
                'perusahaans'  => PerusahaanController::class,
                'karyawans'    => KaryawanController::class,
                'roles'        => RolesController::class,
                'users'        => UsersController::class,
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
            Route::get('/perusahaan', fn () => view('dashboard.perusahaan'))->name('dashboard.perusahaan');
            // Tambahkan route lain untuk perusahaan di sini jika perlu
        });

        /**
         * Karyawan only
         */
        Route::middleware(['role:karyawan'])->group(function () {
            Route::get('/karyawan', fn () => view('dashboard.karyawan'))->name('dashboard.karyawan');
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
Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');
