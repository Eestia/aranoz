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

        return Inertia::render('Home/home', [
            'produits' => $pinnedProducts
        ]);
    }
}
