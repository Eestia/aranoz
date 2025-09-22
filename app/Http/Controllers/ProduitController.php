<?php

namespace App\Http\Controllers;

use App\Models\Couleur;
use App\Models\Produit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProduitController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'=>'require|string|max:255',
            'description'=>'require|string',
            'prix'=>'require|integer|min:0',
            'image'=>'require|image|max:2048',
            //je termine le reste apres!
        ]);
        
        $path = $request->file('image')->store('produits','public');

        //création d'un produit
        Produit::create([
            'titre'=>$validated['titre'],
            'description'=>$validated['description'],
            'prix'=>$validated['prix'],
            'image_path'=>$path,
            'image2_path'=>$path,
            'image3_path'=>$path,
            //je fais la suite apres
        ]);

        return Inertia::location("/produits/index");
    }
}
