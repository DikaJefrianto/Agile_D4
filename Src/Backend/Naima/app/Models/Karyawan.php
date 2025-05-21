<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans'; // Nama tabel di database

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'no_telp',
        'foto',
        'perusahaan_id', // Pastikan kolom ini ada di tabel karyawans
    ];

    // Enkripsi password secara otomatis saat diset
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relasi ke model Perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}
