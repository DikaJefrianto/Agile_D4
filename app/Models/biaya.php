<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class biaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'jenisKendaraan',
        'factorEmisi'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
