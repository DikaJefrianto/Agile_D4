<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua perusahaan yang ada
        $perusahaans = Perusahaan::all();

        foreach ($perusahaans as $perusahaan) {
            // Buat data user untuk setiap karyawan
            $user = User::create([
                'name'          => 'Karyawan ' . $perusahaan->id,
                'email'         => 'karyawan' . $perusahaan->id . '@example.com',
                'password'      => Hash::make('12345678'), // Ganti dengan password yang sesuai
                'role'          => 'karyawan',
                'perusahaan_id' => $perusahaan->id,
            ]);

            // Buat data karyawan untuk setiap perusahaan
            Karyawan::create([
                'nama_lengkap'  => 'Karyawan ' . $perusahaan->id,
                'email'         => $user->email, // Menggunakan email dari user yang baru dibuat
                'password'      => $user->password, // Menggunakan password dari user yang baru dibuat
                'no_telp'       => '+1 (240) 928-029' . $perusahaan->id, // Contoh nomor telepon
                'foto'          => null, // Atau path foto jika ada
                'perusahaan_id' => $perusahaan->id,
                'user_id'       => $user->id, // Mengaitkan user dengan karyawan
                'role'          => 'karyawan',
            ]);
        }
    }
}
