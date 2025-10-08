<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{
    AdresseController,
    BlogController,
    CategorieController,
    CategorieBlogController,
    CommandeController,
    HomeController,
    MailboxController,
    PanierController,
    ProduitController,
    ProfileController,
    TagController,
    UserController
};
use App\Models\{Categorie, CategorieBlog, Couleur, Produit, Tag};

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// ------------------ 🌍 PARTIE PUBLIQUE ------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

// ------------------ 👤 PROFIL UTILISATEUR ------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ------------------ 🏠 PAGE D’ACCUEIL UTILISATEUR ------------------
Route::get('/user/home', fn() => Inertia::render('User/Home/Index'))
    ->middleware(['auth', 'verified'])
    ->name('user.home');

// ✅ Alias pour compatibilité avec route('dashboard')
Route::get('/dashboard', fn() => redirect()->route('user.home'))->name('dashboard');

// ------------------ 🛍️ BOUTIQUE + BLOG ------------------
Route::resource('adresses', AdresseController::class);
Route::resource('produits', ProduitController::class);

// --- Blog public (index et show uniquement)
Route::resource('blogs', BlogController::class)
    ->only(['index', 'show'])
    ->names([
        'index' => 'public.blogs.index',
        'show'  => 'public.blogs.show',
    ]);

// ------------------ 🧺 PANIER ------------------
Route::middleware('auth')->group(function () {
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/{produit}', [PanierController::class, 'add'])->name('panier.add');
    Route::delete('/panier/{produit}', [PanierController::class, 'remove'])->name('panier.remove');
    Route::delete('/panier', [PanierController::class, 'clear'])->name('panier.clear');
});

// ------------------ 🧾 COMMANDES ------------------
Route::middleware('auth')->group(function () {
    Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');
});

Route::middleware(['auth', 'role:admin,agent'])->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::patch('/commandes/{commande}/status', [CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
    Route::post('/commandes/{commande}/contact', [CommandeController::class, 'contactClient'])
        ->middleware('role:agent')->name('commandes.contactClient');
});

// ------------------ 🛒 SHOP / PRODUITS ------------------
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

Route::get('/best-sellers', function () {
    $produits = Produit::orderBy('stock', 'asc')->take(12)->get();
    return inertia('Home/home', ['produits' => $produits]);
})->name('best-sellers');

Route::get('/contact', [AdresseController::class, 'contact'])->name('contact');

// ------------------ 🛠️ PARTIE ADMIN ------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Tableau de bord admin
    Route::get('/dashboard', fn() => Inertia::render('Admin/Home'))
        ->middleware('verified')
        ->name('dashboard');

    // Alias /home (cohérence)
    Route::get('/home', fn() => redirect()->route('admin.dashboard'))->name('home');

    // Upload image produit
    Route::post('/products/{produit}/upload-image', [ProduitController::class, 'uploadImage'])
        ->name('products.upload-image');

    // --- CRUD Admin ---
    Route::resource('users', UserController::class);
    Route::resource('orders', CommandeController::class);
    Route::resource('products', ProduitController::class)->parameters(['products' => 'produit']);
    Route::resource('mailbox', MailboxController::class);

    // --- BLOGS ADMIN ---
    Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

    // --- CATÉGORIES / TAGS ---
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('blog-categories', CategorieBlogController::class);

    Route::get('/category', function () {
        return Inertia::render('Admin/Category', [
            'tags' => Tag::all(),
            'blogCategories' => CategorieBlog::all(),
            'productCategories' => Categorie::all(),
        ]);
    })->name('category');

    // Contact admin
    Route::get('/contact', [AdresseController::class, 'edit'])->name('contact.edit');
    Route::put('/contact/{admin}', [AdresseController::class, 'update'])->name('contact.update');
});

// ------------------ AUTH ------------------
require __DIR__ . '/auth.php';
