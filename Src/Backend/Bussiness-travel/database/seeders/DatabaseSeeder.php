<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SettingsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(SettingsSeeder::class);
<<<<<<< HEAD
=======
        $this->call(PerusahaanSeeder::class);
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
    }
}
