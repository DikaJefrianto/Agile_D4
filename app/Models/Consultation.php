<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Consultation extends Model
{
    //
     protected $fillable = [
        'perusahaan_id',
        'status',
        'requested_date',
        'confirmed_date',
        'meeting_location',
        'notes',
    ];


    public function perusahaan(){
        return $this->belongsTo(perusahaan::class);
    }
}
