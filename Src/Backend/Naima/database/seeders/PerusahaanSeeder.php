<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perusahaan;
use App\Models\User; // Pastikan untuk mengimpor model User
use Faker\Factory as Faker;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Buat 10 data perusahaan acak
        for ($i = 0; $i < 10; $i++) {
            // Buat data perusahaan
            $perusahaan = Perusahaan::create([
                'nama' => $faker->company,
                'username' => $faker->userName,
                'email' => $faker->unique()->safeEmail,
                'foto' => null,
                'password' => bcrypt('password123'),
                'alamat' => $faker->address,
                'keterangan' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Buat pengguna untuk perusahaan yang baru dibuat
            User::create([
                'name' => $perusahaan->nama,
                'email' => $perusahaan->email,
                'password' => bcrypt('password123'), // Password yang di-hash
                'role' => 'perusahaan', // Atau role lain sesuai kebutuhan
                'perusahaan_id' => $perusahaan->id, // Mengaitkan pengguna dengan perusahaan
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
