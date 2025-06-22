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
        return $this->hasMany(Karyawan::class, 'perusahaan_id', 'id');
    }
    public function hasilPerhitungans()
    {
        // Asumsi ada kolom 'perusahaan_id' di tabel 'hasil_perhitungans'
        // Jika tidak ada, Anda perlu menambahkan foreign key ini di migrasi hasil_perhitungans
        return $this->hasMany(HasilPerhitungan::class, 'perusahaan_id');
    }

    // Relasi ke Biaya
    public function biayas()
    {
        // Asumsi ada kolom 'perusahaan_id' di tabel 'biayas'
        // Jika tidak ada, Anda perlu menambahkan foreign key ini di migrasi biayas
        return $this->hasMany(Biaya::class, 'perusahaan_id');
    }
    // Di App\Models\Perusahaan.php
    public function users()
    {
        // Ini untuk user yang merupakan admin/perusahaan
        return $this->belongsTo(User::class, 'user_id');
        return $this->belongsTo(User::class, 'user_id', 'id');// Jika perusahaan.user_id adalah user id yang mengelola perusahaan ini
    }

}
