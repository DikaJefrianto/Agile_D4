<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

   public function test_superadmin_bisa_menambahkan_perusahaan(): void
{
    $this->seed(); // Panggil semua seeder

    // Pastikan role superadmin sudah ada
    \Spatie\Permission\Models\Role::findOrCreate('superadmin', 'web');

    $user = User::where('username', 'superadmin')->first();
    $this->assertNotNull($user);

    // Assign role superadmin jika belum ada
    if (!$user->hasRole('superadmin')) {
        $user->assignRole('superadmin');
    }

    $this->assertTrue($user->hasRole('superadmin'));

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

    $response->assertStatus(302); // atau ->assertRedirect()

    $this->assertDatabaseHas('perusahaans', [
        'nama' => 'PT Laravel Hebat',
        'email' => 'pt@laravel.com',
    ]);
}

}
