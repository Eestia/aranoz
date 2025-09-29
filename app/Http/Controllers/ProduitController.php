<?php

namespace App\Http\Controllers;

use App\Models\Couleur;
use App\Models\Produit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProduitController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Produit::class, 'produit');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'=>'require|string|max:255',
            'description'=>'require|string',
            'prix'=>'require|integer|min:0',
            'image'=>'require|image',
            'image2'=>'require|image',
            'image3'=>'require|image',
            'en_reduction' => 'nullable|boolean',
            'reduction_pct' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'couleur_id' => 'required|exists:couleurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'is_pinned' => 'boolean',
        ]);

        // Si la checkbox n’est pas cochée, on force à false
        $validated['is_pinned'] = $request->has('is_pinned');

        $path = $request->file('image')->store('produits','public');

        //création d'un produit
        Produit::create([
            'titre'=>$validated['titre'],
            'description'=>$validated['description'],
            'prix'=>$validated['prix'],
            'image_path'=>$path,
            'image2_path'=>$path,
            'image3_path'=>$path,
            'en_reduction' => $validated['en_reduction'] ?? false,
            'reduction_pct' => $validated['reduction_pct'] ?? null,
            'stock' => $validated['stock'],
            'couleur_id' => $validated['couleur_id'],
            'categorie_id' => $validated['categorie_id'],
        ]);
        
        return Inertia::location("/produits/index");

    }
    // supression d'un produit: 
    public function destroy($id)
    {
        // on récupère le produit exacte
        $produit = Produit::findOrFail($id);

        // Supprime les images du serveur si elles existent
        if ($produit->image_path && file_exists(public_path($produit->image_path))) {
            unlink(public_path($produit->image_path));
        }
        if ($produit->image2_path && file_exists(public_path($produit->image2_path))) {
            unlink(public_path($produit->image2_path));
        }
        if ($produit->image3_path && file_exists(public_path($produit->image3_path))) {
            unlink(public_path($produit->image3_path));
        }

        // Supprime le produit de la base de données
        $produit->delete();

        return Inertia::location("/produits/index");
        }
        //affichage de la page edit: 
        public function edit($id)
        {
            $produit = Produit::findOrFail($id);

            return Inertia::render('produits/edit', [
                'produit' => $produit
            ]);
        }
        // methode update:
        public function update(Request $request, $id)
        {
            $produit = Produit::findOrFail($id);

            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'prix' => 'required|integer|min:0',
                'image' => 'nullable|image|max:2048',
                'image2' => 'nullable|image|max:2048',
                'image3' => 'nullable|image|max:2048',
                'en_reduction' => 'nullable|boolean',
                'reduction_pct' => 'nullable|integer|min:0|max:100',
                'stock' => 'required|integer|min:0',
                'couleur_id' => 'required|exists:couleurs,id',
                'categorie_id' => 'required|exists:categories,id',
            ]);

            // Gestion des images
            if ($request->hasFile('image')) {
                if ($produit->image_path && file_exists(public_path($produit->image_path))) {
                    unlink(public_path($produit->image_path));
                }
                $validated['image_path'] = $request->file('image')->store('produits', 'public');
            }
            if ($request->hasFile('image2')) {
                if ($produit->image2_path && file_exists(public_path($produit->image2_path))) {
                    unlink(public_path($produit->image2_path));
                }
                $validated['image2_path'] = $request->file('image2')->store('produits', 'public');
            }
            if ($request->hasFile('image3')) {
                if ($produit->image3_path && file_exists(public_path($produit->image3_path))) {
                    unlink(public_path($produit->image3_path));
                }
                $validated['image3_path'] = $request->file('image3')->store('produits', 'public');
            }

            // Met à jour le produit
            $produit->update($validated);

            return Inertia::location("/produits/index");
        }
        public function pinned()
        {
            // Aucune restriction : tout le monde (même non connecté) peut voir les produits pin
            $pinnedProducts = Produit::where('is_pinned', true)
                                    ->latest()
                                    ->take(4)
                                    ->get();

            // Envoie les données au front (Inertia)
            return Inertia::render('Home/home', [
                'produits' => $pinnedProducts
            ]);
        }

}
