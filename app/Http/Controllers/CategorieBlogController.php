<?php

namespace App\Http\Controllers;

use App\Models\CategorieBlog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategorieBlogController extends Controller
{
    // Liste des catégories de blog
    public function index()
    {
        $categories = CategorieBlog::all();
        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    // Affiche le formulaire de création
    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    // Crée une catégorie de blog
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categorie_blogs,nom',
        ]);

        CategorieBlog::create($validated);

        return Inertia::location("/categories/index");
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $categorie = CategorieBlog::findOrFail($id);
        return Inertia::render('Categories/Edit', [
            'categorie' => $categorie
        ]);
    }

    // Met à jour la catégorie de blog
    public function update(Request $request, $id)
    {
        $categorie = CategorieBlog::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categorie_blogs,nom,' . $id,
        ]);

        $categorie->update($validated);

        return Inertia::location("/categories/index");
    }

    // Supprime une catégorie de blog
    public function destroy($id)
    {
        $categorie = CategorieBlog::findOrFail($id);

        // Optionnel : vérifier si des articles existent avant de supprimer
        if ($categorie->blogs()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie ayant des articles.');
        }

        $categorie->delete();

        return Inertia::location("/categories/index");
    }
}
