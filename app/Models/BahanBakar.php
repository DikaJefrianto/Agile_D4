<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBakar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'emisi_per_liter',
    ];

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
