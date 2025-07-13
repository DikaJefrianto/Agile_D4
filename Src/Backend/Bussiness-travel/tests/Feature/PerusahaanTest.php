<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_bisa_menambahkan_perusahaan(): void
{
    // Ambil user yang sudah ada dari seeder
    $user = \App\Models\User::where('email', 'superadmin@example.com')->first();

    // Pastikan role superadmin sudah diberikan
    $user->assignRole('superadmin'); // Pastikan menggunakan Spatie Role package

    // Login sebagai superadmin
    $this->actingAs($user);

    // Kirimkan POST request ke route perusahaan store
    $response = $this->post('/dashboard/perusahaans', [
        'nama' => 'PT Laravel Hebat',
        'username' => 'laravelhebat',
        'email' => 'pt@laravel.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'alamat' => 'Jalan Laravel No.1',
        'keterangan' => 'Testing perusahaan',
    ]);

    $response->assertRedirect(); // 302 redirect
    $this->assertDatabaseHas('perusahaans', [
        'nama' => 'PT Laravel Hebat',
        'email' => 'pt@laravel.com',
    ]);
}

}
