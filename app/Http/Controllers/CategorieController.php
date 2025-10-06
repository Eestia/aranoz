<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;


class CategorieController extends Controller
{
    // LISTE des categorie
    public function index()
    {
        $categories = Categorie::all();
        return Inertia::render('Admin/Category', [
            'categories' => $categories
        ]);
    }

    // AFFICHER FORMULAIRE de creation
    public function create()
    {
        return redirect()->route('admin.category');
    }

    // CREE une categorie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
        ]);

        // Création du slug automatiquement URL-friendly
        $validated['slug'] = Str::slug($validated['nom']);

        Categorie::create($validated);

        return redirect()->route('admin.category');
    }

    // AFFICHER formulaire d'edition
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return Inertia::render('Admin/Category', [
            'categorie' => $categorie
        ]);
    }

    // MET A JOUR la catégorie
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $id,
        ]);

        $validated['slug'] = Str::slug($validated['nom']);

        $categorie->update($validated);

        return redirect()->route('admin.category');
    }

    // SUPPRIME une catégorie
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Vérifie si des produits existent
        if ($categorie->produits()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie ayant des produits.');
        }

        $categorie->delete();

        return redirect()->route('admin.category')->with('success', 'Catégorie supprimée avec succès.');
    }
}
