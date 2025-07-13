<?php

use Spatie\Permission\Models\Role;
use Tests\TestCase; // ✅ Ini yang penting!
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use App\Models\User;


class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_bisa_menambahkan_perusahaan(): void
    {
        // Buat role superadmin secara eksplisit
        Role::create(['name' => 'superadmin', 'guard_name' => 'web']);

        // Buat user manual
        $user = \App\Models\User::factory()->create([
            'email' => 'superadmin@example.com',
            'username' => 'superadmin',
        ]);

        // Assign role langsung
        $user->assignRole('superadmin');

        // Login sebagai superadmin
        $this->actingAs($user);

        // Lakukan request untuk menambah perusahaan
        $response = $this->post('/dashboard/perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'username' => 'laravelhebat',
            'email' => 'pt@laravel.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jalan Laravel No.1',
            'keterangan' => 'Testing perusahaan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'email' => 'pt@laravel.com',
        ]);
    }
}
