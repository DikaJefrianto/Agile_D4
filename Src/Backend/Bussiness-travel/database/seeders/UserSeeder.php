<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'username' => 'superadmin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Perusahan',
                'email' => 'perusahaan@example.com',
                'username' => 'perusahaan',
                'password' => Hash::make('12345678'),
            ],
        ]);

        // Run factory to create additional users with unique details.
        User::factory()->count(50)->create();
        $this->command->info('Users table seeded with 50 users!');
    }
}
