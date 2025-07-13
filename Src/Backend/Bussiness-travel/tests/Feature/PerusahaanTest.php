<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_bisa_menambahkan_perusahaan(): void
    {
        // Jalankan seeder agar user superadmin tersedia
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        // Ambil user yang sudah ada dari seeder
        $user = \App\Models\User::where('email', 'superadmin@example.com')->first();

        // Optional: pastikan role superadmin
        if (!$user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
        }

        // Login sebagai superadmin
        $this->actingAs($user);

        $response = $this->post('/dashboard/perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'username' => 'laravelhebat',
            'email' => 'pt@laravel.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jalan Laravel No.1',
            'keterangan' => 'Testing perusahaan',
        ]);

        $response->assertRedirect(); // Atau ->assertStatus(302)
        $this->assertDatabaseHas('perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'email' => 'pt@laravel.com',
        ]);
    }
}
