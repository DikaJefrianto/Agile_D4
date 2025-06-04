<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    use HasFactory;

    // Sesuaikan jika nama tabel bukan bentuk jamak dari nama model
    protected $table = 'hasil_perhitungans';

    protected $fillable = [
        'user_id',
        'transportasi_id',
        'bahan_bakar_id',
        'biaya_id',
        'nilai_input',
        'jumlah_orang',
        'hasil_emisi',
        'tanggal',
        'metode',
        'kategori'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Transportasi
    public function transportasi()
    {
        return $this->belongsTo(Transportasi::class, 'transportasi_id');
    }

    // Relasi ke Bahan Bakar
    public function bahanBakar()
    {
        return $this->belongsTo(BahanBakar::class, 'bahan_bakar_id');
    }

    // Relasi ke Biaya
    public function biaya()
    {
        return $this->belongsTo(Biaya::class, 'biaya_id');
    }
}
