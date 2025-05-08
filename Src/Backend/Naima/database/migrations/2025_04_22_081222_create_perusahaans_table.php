<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->id();  // Menambahkan kolom id otomatis
            $table->string('nama');  // Kolom nama perusahaan
            $table->string('username')->unique();  // Kolom username, harus unik
            $table->string('email')->unique();  // Kolom email, harus unik
            $table->string('password');  // Kolom password, untuk license
            $table->string('alamat')->nullable();  // Kolom alamat (opsional), nullable artinya bisa kosong
            $table->text('keterangan')->nullable();  // Kolom keterangan (opsional), nullable
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaans');
    }
}
