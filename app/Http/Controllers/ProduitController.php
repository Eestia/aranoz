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
        $this->authorize('view', $produit);

        return Inertia::render('Admin/Products/Show', [
            'produit' => $produit->load(['categorie', 'couleur']),
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

        // 🧠 Regénération du slug si le titre change
        if ($produit->titre !== $validated['titre']) {
            $validated['slug'] = Str::slug($validated['titre']);
        }

        // 📸 Gestion des images
        foreach (['image', 'image2', 'image3'] as $img) {
            $pathKey = "{$img}_path";
            if ($request->hasFile($img)) {
                if ($produit->$pathKey && file_exists(public_path("storage/{$produit->$pathKey}"))) {
                    unlink(public_path("storage/{$produit->$pathKey}"));
                }
                $validated[$pathKey] = $request->file($img)->store('produits', 'public');
            }
        }

        $produit->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    /* =======================
     * 🔹 DESTROY
     * ======================= */
    public function destroy(Produit $produit)
    {
        foreach (['image_path', 'image2_path', 'image3_path'] as $imgPath) {
            if ($produit->$imgPath && file_exists(public_path("storage/{$produit->$imgPath}"))) {
                unlink(public_path("storage/{$produit->$imgPath}"));
            }
        }

        $produit->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès.');
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
}
