<?php

namespace App\Providers;

use App\Models\HasilPerhitungan;
use App\Policies\HasilPerhitunganPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        HasilPerhitungan::class => HasilPerhitunganPolicy::class,
        // Daftarkan policy lain di sini
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
