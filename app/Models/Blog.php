<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }
    //un blog a plusieur commentaires:
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}
