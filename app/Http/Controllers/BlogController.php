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

    public function __construct()
    {
        $this->authorizeResource(Blog::class, 'blog', [
            'except' => ['index', 'show', 'adminIndex']
        ]);
    }

    /* =======================
     * 🔹 PARTIE PUBLIQUE
     * ======================= */

    // Page publique : liste des blogs
    public function index(Request $request)
    {
        $query = Blog::with(['categorie', 'tags'])->latest();

        // Filtres optionnels
        if ($request->filled('category')) {
            $query->whereHas('categorie', fn($q) => $q->where('nom', $request->category));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('nom', $request->tag));
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->get();

        return Inertia::render('Blog/Index', [
            'blogs' => $blogs,
            'categories' => CategorieBlog::all(),
            'tags' => Tag::all(),
            'recentBlogs' => Blog::latest()->take(4)->get(),
            'filters' => $request->only(['category', 'tag', 'search'])
        ]);
    }

    // Page publique : un seul blog
    public function show($id)
    {
        $blog = Blog::with(['categorie', 'tags'])->findOrFail($id);

        return Inertia::render('Blog/show', [
            'blog' => $blog
        ]);
    }


    /* =======================
     * 🔹 PARTIE ADMIN
     * ======================= */

    // Tableau de bord des blogs (admin)
    public function adminIndex()
    {
        $blogs = Blog::with('categorie')->latest()->get();

        return Inertia::render('Admin/Blogs/Index', [
            'blogs' => $blogs,
        ]);
    }

    // Formulaire de création (admin)
    public function create()
    {
        $categories = Categorie::all();

        return Inertia::render('Admin/Blogs/Create', [
            'categories' => $categories
        ]);
    }

    // Création d’un blog (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['image_path'] = $request->hasFile('image')
            ? $request->file('image')->store('blogs', 'public')
            : 'default.jpg';

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog créé avec succès.');
    }

    // Formulaire d’édition (admin)
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Categorie::all();

        return Inertia::render('Admin/Blogs/Edit', [
            'blog' => $blog,
            'categories' => $categories,
        ]);
    }

    // Mise à jour (admin)
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image_path && file_exists(public_path('storage/'.$blog->image_path))) {
                unlink(public_path('storage/'.$blog->image_path));
            }

            $validated['image_path'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog mis à jour avec succès.');
    }

    // Suppression (admin)
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image_path && file_exists(public_path('storage/'.$blog->image_path))) {
            unlink(public_path('storage/'.$blog->image_path));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog supprimé avec succès.');
    }
}
