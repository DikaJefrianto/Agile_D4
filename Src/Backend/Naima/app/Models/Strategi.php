<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategi extends Model
{
    //
    protected $fillable = ['perusahaan_id','nama_program','deskripsi','dokumen', 'status'];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
