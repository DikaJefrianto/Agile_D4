<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategi extends Model
{
    //
    protected $fillable = ['nama_program','deskripsi','dokumen', 'status'];

    public function perusahaan()
    {
        
    }
}
