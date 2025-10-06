<?php

use App\Http\Controllers\AdresseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CategorieBlogController;

use App\Models\Categorie;
use App\Models\CategorieBlog;
use App\Models\Couleur;
use App\Models\Produit;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ------------------ PAGE D’ACCUEIL PUBLIQUE ------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

// ------------------ DASHBOARD (auth obligatoire) ------------------
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ------------------ PROFIL UTILISATEUR ------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ------------------ CRUD PUBLIC ------------------
Route::resource('adresses', AdresseController::class);
Route::resource('produits', ProduitController::class);
Route::resource('blogs', BlogController::class);

// ------------------ PANIER + COMMANDES ------------------
Route::get('/panier', [PanierController::class, 'index'])
     ->name('panier.index')
     ->middleware('auth');

Route::post('/panier/{produit}', [PanierController::class, 'add'])->middleware('auth');
Route::post('/commande', [CommandeController::class, 'store'])->middleware('auth');

// ------------------ COMMANDES (Admin + Agent) ------------------
Route::get('/commandes', [CommandeController::class, 'index'])
     ->middleware(['auth', 'role:admin,agent'])
     ->name('commandes.index');

Route::patch('/commandes/{commande}/status', [CommandeController::class, 'updateStatus'])
     ->middleware(['auth', 'role:admin,agent'])
     ->name('commandes.updateStatus');

Route::post('/commandes/{commande}/contact', [CommandeController::class, 'contactClient'])
     ->middleware(['auth', 'role:agent'])
     ->name('commandes.contactClient');

// ------------------ BEST SELLERS ------------------
Route::get('/best-sellers', function () {
    $produits = Produit::orderBy('stock', 'asc')->take(12)->get();
    return inertia('Home/home', [
        'produits' => $produits
    ]);
})->name('best-sellers');

// ------------------ SHOP ------------------
Route::get('/shop', function () {
    $produits = Produit::with(['categorie', 'couleur'])->get();
    $categories = Categorie::pluck('nom');
    $couleurs = Couleur::pluck('nom');

    return Inertia::render('Shop/Index', [
        'produits' => $produits,
        'categories' => $categories,
        'couleurs' => $couleurs,
    ]);
})->name('shop');

// ------------------ CONTACT ------------------
Route::get('/Contact', [AdresseController::class, 'contact'])->name('contact');

// ------------------ ADMIN ------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard admin → redirection vers /admin/home
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/home');
        }
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Page home admin
    Route::get('/home', function () {
        return Inertia::render('Admin/home');
    })->middleware(['auth', 'verified'])->name('home');

    // CRUD Admin généraux
    Route::resource('users', UserController::class);
    Route::resource('orders', CommandeController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('products', ProduitController::class);
    Route::resource('mailbox', MailboxController::class);

    // CRUD spécifiques pour la page Category (les 3)
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('blog-categories', CategorieBlogController::class);

    // Page qui rassemble les 3 CRUD
    Route::get('/Category', function () {
        return Inertia::render('Admin/Category', [
            'tags' => Tag::all(),
            'blogCategories' => CategorieBlog::all(),
            'productCategories' => Categorie::all(),
        ]);
    })->name('category');
});

// ------------------ AUTH ------------------
require __DIR__.'/auth.php';
