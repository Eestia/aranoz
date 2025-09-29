<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande_item extends Model
{
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
