<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metodes', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Contoh: bahan_bakar, jarak_tempuh, biaya
            $table->string('deskripsi')->nullable(); // Penjelasan tambahan jika perlu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodes');
    }
};
