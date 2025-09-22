<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieBlog extends Model
{
     public function blogs()
    {
        return $this->hasMany(Blog::class, 'categorie_id');
    }
}
