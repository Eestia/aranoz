<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom', 'slug'];

    /**
     * Relation : une catégorie possède plusieurs produits
     */
    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }
}