<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PanierController extends Controller
{
    /**
     * Affiche le contenu du panier
     */
    public function index()
    {
        $panier = session()->get('panier', []);
        $total = collect($panier)->sum(fn($item) => $item['prix'] * $item['quantite']);

        return Inertia::render('Panier/Index', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(Request $request, Produit $produit)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$produit->id])) {
            $panier[$produit->id]['quantite']++;
        } else {
            $panier[$produit->id] = [
                'id' => $produit->id,
                'nom' => $produit->nom,
                'prix' => $produit->prix,
                'image' => $produit->image_path ?? null,
                'quantite' => 1,
            ];
        }

        session()->put('panier', $panier);

        return back()->with('success', 'Produit ajouté au panier.');
    }

    /**
     * Supprime un produit du panier
     */
    public function remove(Produit $produit)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$produit->id])) {
            unset($panier[$produit->id]);
            session()->put('panier', $panier);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vide entièrement le panier
     */
    public function clear()
    {
        session()->forget('panier');
        return back()->with('success', 'Panier vidé.');
    }
}