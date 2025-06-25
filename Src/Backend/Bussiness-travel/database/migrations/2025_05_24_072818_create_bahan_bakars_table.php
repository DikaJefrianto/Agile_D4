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
        Schema::create('bahan_bakars', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('nama');
            $table->float('emisi_per_liter');
=======
            $table->string('kategori');
            $table->string('Bahan_bakar');
            $table->decimal('factorEmisi', 10, 4);
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakars');
    }
<<<<<<< HEAD
};
=======
};
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
