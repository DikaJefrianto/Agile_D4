<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_bisa_menambahkan_perusahaan()
    {
        // Buat role superadmin kalau belum ada
        Role::firstOrCreate(['name' => 'superadmin']);

        // Buat user dan assign role superadmin
        $superadmin = User::factory()->create([
            'email_verified_at' => now(), // wajib kalau pakai 'verified' middleware
        ]);
        $superadmin->assignRole('superadmin');

        // Login sebagai superadmin dan kirim data perusahaan
        $response = $this->actingAs($superadmin)->post(route('admin.perusahaans.store'), [
            'nama' => 'PT Laravel Hebat',
            'username' => 'ptlaravel',
            'email' => 'pt@laravel.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jalan Laravel No.1',
            'keterangan' => 'Testing perusahaan',
        ]);

        // Validasi: response harus redirect
        $response->assertRedirect();

        // Validasi: data harus masuk ke database
        $this->assertDatabaseHas('perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'email' => 'pt@laravel.com',
        ]);
    }
}
