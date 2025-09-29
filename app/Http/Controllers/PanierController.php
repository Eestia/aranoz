<?php

namespace App\Http\Controllers;

use App\Models\Panier_item;
use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()
                         ->panierItems()
                         ->with('produit')
                         ->get();

        return inertia('Panier/Index', ['items' => $items]);
    }

    public function add(Request $request, Produit $produit)
    {
        $request->user()->panierItems()->updateOrCreate(
            ['produit_id' => $produit->id],
            ['quantite' => \DB::raw('quantite + 1')]
        );

        return back()->with('success', 'Produit ajouté au panier');
    }

    // public function remove(Panier_item $item)
    // {
    //     $this->authorize('delete', $item); // facultatif si policy
    //     $item->delete();

    //     return back()->with('success', 'Produit retiré du panier');
    // }
}
