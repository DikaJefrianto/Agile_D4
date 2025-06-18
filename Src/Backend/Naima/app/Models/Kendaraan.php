<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'bahan_bakar_id',
        'efisiensi_km_per_liter',
    ];

    public function bahanBakar()
    {
        return $this->belongsTo(BahanBakar::class);
    }
}
