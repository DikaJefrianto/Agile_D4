<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('perhitungans', function (Blueprint $table) {
            $table->id(); // no
            $table->string('metode'); // metode perhitungan: bahan_bakar / jarak / biaya
            $table->string('kategori'); // kategori transportasi: darat / laut / udara
            $table->string('jenis'); // jenis kendaraan
            $table->string('nilai_input'); // bisa berupa jumlah bahan bakar, jarak, atau biaya
            $table->integer('jumlah_orang'); // jumlah orang
            $table->float('hasil_emisi'); // hasil emisi yang dihitung
            $table->date('tanggal'); // tanggal perhitungan
            $table->timestamps(); // created_at, updated_at
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perhitungans');
    }
};
