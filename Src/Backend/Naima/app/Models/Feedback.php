<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $fillable = ['kategori', 'deskripsi','user_id',];
    protected $table = 'feedbacks';

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
