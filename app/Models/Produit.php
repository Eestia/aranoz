<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'titre','description','image_path','image2_path','image3_path',
        'prix','en_reduction','reduction_pct','stock','couleur_id','categorie_id'
    ];

    public function couleur ()
    {
        return $this->belongsTo(Couleur::class);
    }
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function getPrixFinalAttribute()
    {
        if ($this->en_reduction && $this->reduction_pct){
            return $this->prix * (1 - $this->reduction_pct/100);
        }
        return $this->prix;
    }
    //retourne l'url complete pour l'affichage:
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
    public function getImage2UrlAttribute()
    {
        return asset('storage/' . $this->image2_path);
    }
    public function getImage3UrlAttribute()
    {
        return asset('storage/' . $this->image3_path);
    }
}
