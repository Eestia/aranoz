<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    public function produit()
    {
        return $this->hasMany(Produit::class);
    }
}
