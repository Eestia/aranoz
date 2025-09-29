<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public function items()
{
    return $this->hasMany(Commande_item::class);
}

}
