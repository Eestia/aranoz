<?php

use App\Http\Controllers\{
    AdresseController,
    BlogController,
    CommandeController,
    HomeController,
    PanierController,
    ProduitController,
    ProfileController,
    TagController,
    UserController,
    MailboxController,
    CategorieController,
    CategorieBlogController
};
use App\Models\{Categorie, CategorieBlog, Couleur, Produit, Tag};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// ------------------ 🌍 PARTIE PUBLIQUE ------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', fn() => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD publics
Route::resource('adresses', AdresseController::class);
Route::resource('produits', ProduitController::class);
Route::resource('blogs', BlogController::class)->only(['index', 'show']); // public blog listing + show

// Panier + commandes
Route::get('/panier', [PanierController::class, 'index'])->middleware('auth')->name('panier.index');
Route::post('/panier/{produit}', [PanierController::class, 'add'])->middleware('auth');
Route::post('/commande', [CommandeController::class, 'store'])->middleware('auth');

// Commandes (admin + agent)
Route::middleware(['auth', 'role:admin,agent'])->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::patch('/commandes/{commande}/status', [CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
    Route::post('/commandes/{commande}/contact', [CommandeController::class, 'contactClient'])
        ->middleware('role:agent')->name('commandes.contactClient');
});

// Best sellers
Route::get('/best-sellers', function () {
    $produits = Produit::orderBy('stock', 'asc')->take(12)->get();
    return inertia('Home/home', ['produits' => $produits]);
})->name('best-sellers');

// Shop
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

// Contact public
Route::get('/contact', [AdresseController::class, 'contact'])->name('contact');


// ------------------ 🛠️ PARTIE ADMIN ------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', fn() => Inertia::render('Admin/Home'))
        ->middleware('verified')
        ->name('dashboard');

    // Page d’accueil admin
    Route::get('/home', fn() => Inertia::render('Admin/Home'))->name('home');

    // --- CRUD Admin généraux ---
    Route::resource('users', UserController::class);
    Route::resource('orders', CommandeController::class);
    Route::resource('products', ProduitController::class);
    Route::resource('mailbox', MailboxController::class);

    // --- CRUD Blogs Admin ---
    Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');

    // --- CRUD Catégories / Tags ---
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('blog-categories', CategorieBlogController::class);

    // Page regroupant les 3 CRUD
    Route::get('/category', function () {
        return Inertia::render('Admin/Category', [
            'tags' => Tag::all(),
            'blogCategories' => CategorieBlog::all(),
            'productCategories' => Categorie::all(),
        ]);
    })->name('category');

    // --- Contact admin (édition adresse entreprise) ---
    Route::get('/contact', [AdresseController::class, 'edit'])->name('contact.edit');
    Route::put('/contact/{admin}', [AdresseController::class, 'update'])->name('contact.update');
});

// ------------------ AUTH ------------------
require __DIR__ . '/auth.php';
