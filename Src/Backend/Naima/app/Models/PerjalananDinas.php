<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerjalananDinas extends Model
{
    use HasFactory;

    protected $table = 'perjalanan_dinas';

    protected $fillable = [
        'karyawan_id',
        'tujuan',
        'mode_transportasi',
        'jarak_km',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function perhitungan()
    {
        return $this->hasOne(Perhitungan::class, 'perjalanan_id');
    }
}
