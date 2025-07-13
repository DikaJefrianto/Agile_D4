<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_bisa_menambahkan_perusahaan()
    {
        // Buat role superadmin (jika belum ada)
        Role::create(['name' => 'superadmin']);

        // Buat user dan assign role superadmin
        $superadmin = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $superadmin->assignRole('superadmin');

        // Akses route untuk menambahkan perusahaan
        $response = $this->actingAs($superadmin)->post(route('admin.perusahaans.store'), [
            'nama' => 'PT Laravel Hebat',
            'username' => 'ptlaravel',
            'email' => 'pt@laravel.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jalan Laravel No.1',
            'keterangan' => 'Testing perusahaan',
        ]);

        // Assert redirect atau sukses
        $response->assertRedirect(); // atau ->assertStatus(302)
        $this->assertDatabaseHas('perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'email' => 'pt@laravel.com',
        ]);
    }
}
