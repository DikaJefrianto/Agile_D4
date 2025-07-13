<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Jalankan seeder untuk mendapatkan superadmin
        $this->artisan('db:seed', ['--class' => 'UserSeeder']);
    }

    public function test_superadmin_bisa_menambahkan_perusahaan()
    {
        $superadmin = User::where('email', 'superadmin@example.com')->first();

        $response = $this->actingAs($superadmin)->post(route('admin.perusahaans.store'), [
            'nama' => 'PT Laravel Hebat',
            'username' => 'ptlaravel',
            'email' => 'pt@laravel.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jalan Laravel No.1',
            'keterangan' => 'Testing perusahaan',
        ]);


        $response->assertRedirect(); // Atau assertStatus(302) jika belum redirect ke URL spesifik
        $this->assertDatabaseHas('perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'email' => 'pt@laravel.com',
        ]);
    }
}
