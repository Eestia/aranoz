<?php

namespace App\Http\Controllers;

use App\Models\CategorieBlog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategorieBlogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(CategorieBlog::class, 'categorie_blog');
    }

    // Liste des catégories de blog
    public function index()
    {
        $categories = CategorieBlog::all();
        return Inertia::render('Admin/Category', [
            'blogCategories' => $categories, 
        ]);
    }

    // Formulaire de création (redirige simplement vers la page principale)
    public function create()
    {
        return redirect()->route('admin.category');
    }

    // Crée une catégorie de blog
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categorie_blogs,nom',
        ]);

        CategorieBlog::create($validated);

        return redirect()
            ->route('admin.category')
            ->with('success', 'Catégorie de blog ajoutée avec succès !');
    }

    // Formulaire d’édition
    public function edit($id)
    {
        $categorie = CategorieBlog::findOrFail($id);
        return Inertia::render('Admin/Category', [
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

        return redirect()
            ->route('admin.category')
            ->with('success', 'Catégorie de blog mise à jour avec succès !');
    }

    // Supprime une catégorie de blog
    public function destroy($id)
    {
        $categorie = CategorieBlog::findOrFail($id);

        // Vérifier si des articles existent avant de supprimer
        if (method_exists($categorie, 'blogs') && $categorie->blogs()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie ayant des articles.');
        }

        $categorie->delete();

        return redirect()
            ->route('admin.category')
            ->with('success', 'Catégorie de blog supprimée avec succès !');
    }
}