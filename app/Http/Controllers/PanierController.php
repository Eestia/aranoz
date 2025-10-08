<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Inertia\Inertia;

class PanierController extends Controller
{
    // ✅ Afficher le panier
    public function index()
    {
        $panier = session()->get('panier', []);
        $total = array_sum(array_map(fn($item) => $item['prix'] * $item['quantite'], $panier));

        return Inertia::render('Panier/Index', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }

    // ✅ Ajouter un produit
    public function add(Request $request, Produit $produit)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$produit->id])) {
            $panier[$produit->id]['quantite']++;
        } else {
            $panier[$produit->id] = [
                'id' => $produit->id,
                'nom' => $produit->titre,
                'prix' => $produit->prix,
                'image' => $produit->image_path ?? null,
                'quantite' => 1,
            ];
        }

        session()->put('panier', $panier);

        return response()->json(['message' => '✅ Produit ajouté au panier']);
    }

    // 🗑️ Supprimer un produit
    public function remove(Produit $produit)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$produit->id])) {
            unset($panier[$produit->id]);
            session()->put('panier', $panier);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }

    // 🧹 Vider le panier
    public function clear()
    {
        session()->forget('panier');
        return back()->with('success', 'Panier vidé.');
    }
}
