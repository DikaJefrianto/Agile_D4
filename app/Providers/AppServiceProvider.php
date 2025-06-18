<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    if (app()->runningInConsole() && !app()->runningUnitTests()) {
        return;
    }

    try {
        if (\Schema::hasTable('settings')) {
            $setting = \DB::table('settings')->first();
            config(['app.name' => $setting->app_name]);
        }
    } catch (\Exception $e) {
        // abaikan error
    }
}

}
