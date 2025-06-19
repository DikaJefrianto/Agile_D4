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
        Schema::table('hasil_perhitungans', function (Blueprint $table) {
            Schema::table('hasil_perhitungans', function (Blueprint $table) {
                $table->string('alamat_awal')->nullable();
                $table->string('alamat_tujuan')->nullable();
                $table->decimal('latitude_awal', 10, 7)->nullable();
                $table->decimal('longitude_awal', 10, 7)->nullable();
                $table->decimal('latitude_tujuan', 10, 7)->nullable();
                $table->decimal('longitude_tujuan', 10, 7)->nullable();
            });
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_perhitungans', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_awal',
                'alamat_tujuan',
                'latitude_awal',
                'longitude_awal',
                'latitude_tujuan',
                'longitude_tujuan',
            ]);
        });
    }
};
