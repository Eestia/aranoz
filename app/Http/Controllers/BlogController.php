<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categorie;
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
    public function index()
    {
        $blogs = Blog::with('categorie')->latest()->get();
        $categories = Categorie::all();
        $recentBlogs = Blog::latest()->take(4)->get();

        return Inertia::render('Blog/Index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'recentBlogs' => $recentBlogs,
            // 'tags' => Tag::all() // si tu veux les tags
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
            'categorie_id' => 'required|exists:categories,id',
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
}
