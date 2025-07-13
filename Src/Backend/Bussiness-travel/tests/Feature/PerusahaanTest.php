<?php

use Spatie\Permission\Models\Role;
use Tests\TestCase; // ✅ Ini yang penting!
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;


class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_bisa_menambahkan_perusahaan(): void
{
    $this->seed(); // Jalankan semua seeder: user, role, dan permission

    $user = User::where('username', 'superadmin')->first();
    $this->assertTrue($user->hasRole('superadmin'));
    $this->assertTrue($user->can('perusahaan.create'));

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

        $response->assertRedirect();
        $this->assertDatabaseHas('perusahaans', [
            'nama' => 'PT Laravel Hebat',
            'email' => 'pt@laravel.com',
        ]);
    }
}
