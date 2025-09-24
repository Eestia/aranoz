<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    protected $fillable = [
        'rue', 'numero', 'ville', 'code_postal',
        'pays', 'code_pays', 'tel', 'email', 'user_id',
    ];
    // adresse appartient à user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
