<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['user_id', 'kategori', 'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $table = 'feedbacks';
}
