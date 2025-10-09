<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'user_id', 'total', 'mode_paiement', 'status', 'billing', 'shipping'
    ];

    protected $casts = [
        'billing' => 'array',
        'shipping' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
{
    return $this->hasMany(Commande_item::class);
}

}
