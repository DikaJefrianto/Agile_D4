<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perhitungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'metode',
        'kategori',
        'jenis',
        'nilai_input',
        'jumlah_orang',
        'hasil_emisi',
        'tanggal',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

