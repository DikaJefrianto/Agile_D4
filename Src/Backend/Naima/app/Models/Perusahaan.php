<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel (misalnya 'perusahaans')
    protected $table = 'perusahaans';

    // Tentukan kolom mana yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'alamat',
        'keterangan',
    ];

    // Tentukan kolom mana yang tidak bisa diisi (untuk keamanan, biasanya diisi dengan kolom 'id' atau 'created_at' dan 'updated_at')
    protected $guarded = ['id'];

    // Set default casting untuk tipe data kolom
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator untuk mengenkripsi password secara otomatis saat diset
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Accessor untuk menampilkan nama lengkap perusahaan (contoh jika diperlukan)
     */
    public function getFullNameAttribute()
    {
        return $this->nama . ' (' . $this->username . ')';
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'perusahaan_id');
    }
}
