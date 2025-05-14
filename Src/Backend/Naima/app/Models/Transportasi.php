<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'jenis',
        'factor_emisi'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
