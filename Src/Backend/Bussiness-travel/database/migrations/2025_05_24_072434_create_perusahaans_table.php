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
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama', 255);
            $table->string('email', 255)->unique();
            $table->string('alamat')->nullable();
<<<<<<< HEAD
            $table->string('logo')->nullable(); // disamakan dengan 'foto'
=======
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
