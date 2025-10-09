<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);
        $total = array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $panier));

        return Inertia::render('Checkout/Index', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }
}
