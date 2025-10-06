<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TagController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    // Liste des tags
    public function index()
    {
        $tags = Tag::all();
        return Inertia::render('Admin/Category', [
            'tags' => $tags
        ]);
    }

    // Formulaire de création (facultatif, tu bosses sûrement en modal dans Admin/Category)
    public function create()
    {
        return Inertia::render('Admin/Category');
    }

    // Création d'un tag
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:tags,nom',
        ]);

        Tag::create($validated);

        return redirect()
            ->route('admin.category')
            ->with('success', 'Tag ajouté avec succès !');
    }

    // Formulaire d'édition (facultatif si tu fais inline)
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return Inertia::render('Admin/Category', [
            'tag' => $tag
        ]);
    }

    // Mise à jour d'un tag
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:tags,nom,' . $id,
        ]);

        $tag->update($validated);

        return redirect()->route('admin.category');
    }

    // Suppression d'un tag
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        // Optionnel : vérifier si le tag est utilisé par des articles
        if (method_exists($tag, 'blogs') && $tag->blogs()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un tag utilisé par des articles.');
        }

        $tag->delete();

        return redirect()->route('admin.category');
    }
}
