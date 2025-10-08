<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProduitController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Produit::class, 'produit');
    }

    /* =======================
     * 🔹 ADMIN : INDEX
     * ======================= */
    public function index()
    {
        $produits = Produit::with(['categorie', 'couleur'])->latest()->get();

        return Inertia::render('Admin/Products/Index', [
            'produits' => $produits,
        ]);
    }

    /* =======================
     * 🔹 SHOW
     * ======================= */
    public function show(Produit $produit)
{
    // Si c’est l’admin
    if (request()->routeIs('admin.*')) {
        return inertia('Admin/Products/Show', [
            'produit' => $produit,
        ]);
    }

    // Si l’utilisateur est connecté
    if (auth()->check()) {
        return inertia('User/Products/Show', [
            'produit' => $produit,
        ]);
    }

    // Sinon, visiteur public
    return inertia('produits/show', [
        'produit' => $produit,
    ]);
}


    /* =======================
     * 🔹 CREATE
     * ======================= */
    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Categorie::all(),
            'couleurs' => Couleur::all(),
        ]);
    }

    /* =======================
     * 🔹 STORE
     * ======================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'couleur_id' => 'required|exists:couleurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'en_reduction' => 'nullable|boolean',
            'reduction_pct' => 'nullable|integer|min:0|max:100',
            'is_pinned' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'image2' => 'nullable|image|max:2048',
            'image3' => 'nullable|image|max:2048',
        ]);

        // 🧠 Génération automatique du slug
        $validated['slug'] = Str::slug($validated['titre']);

        // 📸 Uploads des images
        foreach (['image', 'image2', 'image3'] as $img) {
            if ($request->hasFile($img)) {
                $validated["{$img}_path"] = $request->file($img)->store('produits', 'public');
            }
        }

        Produit::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès.');
    }

    /* =======================
     * 🔹 EDIT
     * ======================= */
    public function edit(Produit $produit)
    {
        return Inertia::render('Admin/Products/Edit', [
            'produit' => $produit,
            'categories' => Categorie::all(),
            'couleurs' => Couleur::all(),
        ]);
    }

    /* =======================
     * 🔹 UPDATE
     * ======================= */
    public function update(Request $request, Produit $produit)
{
    // ✅ Validation des champs
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'categorie_id' => 'required|exists:categories,id',
        'couleur_id' => 'required|exists:couleurs,id',
        'en_reduction' => 'nullable|boolean',
        'reduction_pct' => 'nullable|numeric|min:0|max:100',
        'is_pinned' => 'nullable|boolean',
        'image' => 'nullable|image|max:2048',
        'image2' => 'nullable|image|max:2048',
        'image3' => 'nullable|image|max:2048',
    ]);

    // 🧠 Regénère le slug seulement si le titre change
    if ($produit->titre !== $validated['titre']) {
        $validated['slug'] = Str::slug($validated['titre']);
    }

    // 📸 Gestion des images
    foreach (['image', 'image2', 'image3'] as $img) {
        if ($request->hasFile($img)) {
            // Supprime l'ancienne si elle existe
            $oldPath = $produit->{$img . '_path'};
            if ($oldPath && file_exists(public_path('storage/' . $oldPath))) {
                @unlink(public_path('storage/' . $oldPath));
            }

            // Sauvegarde la nouvelle image
            $path = $request->file($img)->store('produits', 'public');
            $validated[$img . '_path'] = $path;
        }
    }

    // On retire les clés inutiles avant update()
    unset($validated['image'], $validated['image2'], $validated['image3']);

    // 🧾 Mise à jour du produit
    $produit->update($validated);

    return redirect()
        ->route('admin.products.index')
        ->with('success', '✅ Produit mis à jour avec succès.');
}



    /* =======================
     * 🔹 DESTROY
     * ======================= */
    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);

        $produit->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    /* =======================
     * 🔹 PRODUITS ÉPINGLÉS
     * ======================= */
    public function pinned()
    {
        $pinnedProducts = Produit::where('is_pinned', true)->latest()->take(4)->get();

        return Inertia::render('Home/home', [
            'produits' => $pinnedProducts,
        ]);
    }

    /* =======================
     * 🔹 BEST SELLERS
     * ======================= */
    public function bestSellers()
    {
        $produits = Produit::orderBy('stock', 'asc')->take(20)->get();
        return response()->json($produits);
    }

    public function uploadImage(Request $request, Produit $produit)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        // Supprime l'ancienne image si nécessaire
        if ($produit->image_path && file_exists(public_path('storage/' . $produit->image_path))) {
            unlink(public_path('storage/' . $produit->image_path));
        }

        // Stocke la nouvelle
        $path = $request->file('image')->store('produits', 'public');

        // Met à jour la colonne correspondante
        $produit->update(['image_path' => $path]);

        return response()->json([
            'message' => 'Image mise à jour avec succès',
            'path' => $path,
        ]);
    }
}
