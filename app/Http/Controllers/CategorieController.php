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
        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    // AFFICHER FORMULAIRE de creation
    public function create()
    {
        return Inertia::render('Categories/Create');
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

        return Inertia::location("/categories/index");
    }

    // AFFICHER formulaire d'edition
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return Inertia::render('Categories/Edit', [
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

        return Inertia::location("/categories/index");
    }

    // SUPPRIME une catégorie
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        // vérifie si des produits existent avant de supprimer
        if ($categorie->produits()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie ayant des produits.');
        }

        $categorie->delete();

        return Inertia::location("/categories/index");
    }
}
