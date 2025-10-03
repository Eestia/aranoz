<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categorie;
use App\Models\CategorieBlog;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Inertia\Inertia;

class BlogController extends Controller
{
    use AuthorizesRequests;
    // Apelle automatiquement la bonne methode pour chaque role: 
    public function __construct()
    {
       $this->authorizeResource(Blog::class, 'blog', [
        'except' => ['index', 'show']
    ]);
    }
    // Liste des blogs
    public function index(Request $request)
    {
        $query = Blog::with(['categorie', 'tags'])->latest();

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->whereHas('categorie', function ($q) use ($request) {
                $q->where('nom', $request->category);
            });
        }

        // Filtre par tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('nom', $request->tag);
            });
        }

        // Filtre par recherche
        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->with(['categorie', 'tags'])->get();

        return Inertia::render('Blog/Index', [
            'blogs' => $blogs,
            'categories' => CategorieBlog::all(),
            'tags' => Tag::all(),
            'recentBlogs' => Blog::latest()->take(4)->get(),
            'filters' => $request->only(['category', 'tag', 'search']) // ✅ utile pour garder l’état côté React
        ]);
    }



    // Formulaire de création
    public function create()
    {
        $categories = Categorie::all();
        return Inertia::render('Blog/create', [
            'categories' => $categories
        ]);
    }

    // Création d'un blog
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $validated['image_path'] = $request->file('image')->store('blogs', 'public');

        Blog::create($validated);

        return Inertia::location("/blogs/index");
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Categorie::all();

        return Inertia::render('Blog/Edit', [
            'blog' => $blog,
            'categories' => $categories
        ]);
    }

    // Mise à jour d'un blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'categorie_id' => 'required|exists:categorie_blogs,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            if ($blog->image_path && file_exists(public_path('storage/'.$blog->image_path))) {
                unlink(public_path('storage/'.$blog->image_path));
            }
            $validated['image_path'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return Inertia::location("/blogs/index");
    }

    // Suppression d'un blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image_path && file_exists(public_path('storage/'.$blog->image_path))) {
            unlink(public_path('storage/'.$blog->image_path));
        }

        $blog->delete();

        return Inertia::location("/blogs/index");
    }
    public function show($id)
    {
        $blog = Blog::with(['categorie', 'tags'])->findOrFail($id);

        return Inertia::render('Blog/show', [
            'blog' => $blog
        ]);
    }
}   
