<?php

use App\Http\Controllers\AdresseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//------------------- mes routes ajoutées: 

    //blog:
Route::resource('blogs', BlogController::class);
    //Tag
Route::resource('tags', TagController::class);
    //Adresse
Route::resource('adresses', AdresseController::class);
    //Produit
Route::resource('produits', ProduitController::class);
    //Produit Pin dans la page Home
// Route::get('/', [ProduitController::class, 'home'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

//------------------------------------------------------------------
// Afficher le panier
Route::get('/panier', [PanierController::class, 'index'])
     ->name('panier.index')
     ->middleware('auth');

// Ajouter un produit au panier
Route::post('/panier/{produit}', [PanierController::class, 'add'])->middleware('auth');

// Valider la commande
Route::post('/commande', [CommandeController::class, 'store'])->middleware('auth');

// Afficher les commandes (admin / agent)
Route::get('/commandes', [CommandeController::class, 'index'])
     ->middleware(['auth', 'role:admin,agent']);

// Changer le statut d’une commande
Route::patch('/commandes/{commande}/status', [CommandeController::class, 'updateStatus'])
     ->middleware(['auth', 'role:admin,agent']);

//-----------route pour autorisation de l'agent:
Route::middleware(['auth', 'role:agent'])->group(function () {
    // Voir toutes les commandes
    Route::get('/commandes', [CommandeController::class, 'index'])
        ->name('commandes.index');

    // Mettre à jour le statut d’une commande
    Route::patch('/commandes/{commande}/status', [CommandeController::class, 'updateStatus'])
        ->name('commandes.updateStatus');

    // Envoyer un mail au client (optionnel, via formulaire)
    Route::post('/commandes/{commande}/contact', [CommandeController::class, 'contactClient'])
        ->name('commandes.contactClient');
});
require __DIR__.'/auth.php';
