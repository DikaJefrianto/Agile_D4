<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perusahaan;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            Perusahaan::create([
                'nama' => $faker->company,
                'email' => $faker->unique()->companyEmail,
                'alamat' => $faker->address,
                'logo' => 'logo_' . Str::random(10) . '.png', // Simulasi nama file logo
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
