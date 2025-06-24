<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'hasil_perhitungans'; // Pastikan nama tabelnya benar

    protected $fillable = [
        'user_id',
        'metode',
        'transportasi_id',
        'bahan_bakar_id',
        'biaya_id',
        'nilai_input',
        'jumlah_orang',
        'hasil_emisi',
        'tanggal', // Kolom tanggal perhitungan
        'kategori',
        'titik_awal',
        'titik_tujuan',
    ];

    // --- TAMBAHKAN ATAU MODIFIKASI BAGIAN INI ---
    protected $casts = [
        'tanggal' => 'datetime', // Mengonversi 'tanggal' menjadi objek Carbon
    ];
    // --- AKHIR PERBAIKAN ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transportasi()
    {
        return $this->belongsTo(Transportasi::class);
    }

    public function bahanBakar()
    {
        return $this->belongsTo(BahanBakar::class, 'bahan_bakar_id');
    }

    public function biaya()
    {
        return $this->belongsTo(Biaya::class);
    }
}

