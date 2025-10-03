<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieBlog extends Model
{
    protected $fillable = ['nom'];
     public function blogs()
    {
        return $this->hasMany(Blog::class, 'categorie_id');
    }
}
