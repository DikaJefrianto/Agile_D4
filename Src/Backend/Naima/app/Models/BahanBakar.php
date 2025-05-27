<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBakar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'Bahan_bakar',
        'factorEmisi'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
