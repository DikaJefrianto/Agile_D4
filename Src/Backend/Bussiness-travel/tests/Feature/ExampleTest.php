<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_dapat_menambahkan_perusahaan_baru()
    {
        $response = $this->post('/perusahaans', [  // Ganti dengan route yang sesuai
            'nama' => 'PT Testing Sukses',
            'username' => 'testing123',
            'email' => 'testing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jl. Testing No. 123',
            'keterangan' => 'Perusahaan untuk pengujian',
        ]);

        $response->assertRedirect(); // Pastikan redirect (biasanya ke index atau detail)
        $this->assertDatabaseHas('perusahaans', [ // Ganti dengan nama tabel yang sesuai
            'nama' => 'PT Testing Sukses',
            'email' => 'testing@example.com',
        ]);
    }
}
