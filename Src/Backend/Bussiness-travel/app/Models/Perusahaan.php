<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Perusahaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'alamat',
        'logo',
        'keterangan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi lain jika ada, misal ke karyawan
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
