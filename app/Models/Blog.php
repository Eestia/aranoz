<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'image_path',
        'categorie_id',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    public function categorie()
    {
        return $this->belongsTo(CategorieBlog::class,'categorie_id');
    }
    //un blog a plusieur commentaires:
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    // relation vers categorie_blog
    // public function categorieBlog()
    // {
    //     return $this->belongsTo(\App\Models\CategorieBlog::class, 'categorie_blog_id');
    // }
}
