<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Produit;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
{
    $pinnedProducts = Produit::where('is_pinned', true)->get();
    $produits = Produit::all();

    return Inertia::render('Home/home', [
        'pinned'   => $pinnedProducts,
        'produits' => $produits,
    ]);
}

}
