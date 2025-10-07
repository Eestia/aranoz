<?php

namespace App\Http\Controllers;

use App\Models\Blog;
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
            'filters' => $request->only(['category', 'tag', 'search']),
        ]);
    }

    public function show($id)
    {
        $blog = Blog::with(['categorie', 'tags'])->findOrFail($id);
        return inertia('Admin/Blogs/Show', ['blog' => $blog]);
    }

    /* =======================
     * 🔹 PARTIE ADMIN
     * ======================= */

    public function adminIndex()
    {
        $blogs = Blog::with('categorie')->latest()->get();

        return Inertia::render('Admin/Blogs/Index', [
            'blogs' => $blogs,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Blogs/Create', [
            'categories' => CategorieBlog::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'categorie_id' => 'required|exists:categorie_blogs,id',
            'tags' => 'array',
        ]);

        $blog = new Blog();
        $blog->titre = $validated['titre'];
        $blog->description = $validated['description'];
        $blog->categorie_id = $validated['categorie_id'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $blog->image_path = $path;
        }

        $blog->save();

        if (!empty($validated['tags'])) {
            $blog->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }


    public function edit($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        $categories = CategorieBlog::all();
        $tags = Tag::all();

        return Inertia::render('Admin/Blogs/Edit', [
            'blog' => $blog,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'categorie_id' => 'required|exists:categorie_blogs,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'tag_ids' => 'array',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            if ($blog->image_path && file_exists(public_path('storage/' . $blog->image_path))) {
                unlink(public_path('storage/' . $blog->image_path));
            }

            $validated['image_path'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update([
            'categorie_id' => $validated['categorie_id'],
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'image_path' => $validated['image_path'] ?? $blog->image_path,
        ]);

        $blog->tags()->sync($request->input('tag_ids', []));

        return Inertia::location(route('admin.blogs.index'));
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image_path && file_exists(public_path('storage/' . $blog->image_path))) {
            unlink(public_path('storage/' . $blog->image_path));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog supprimé avec succès.');
    }

}
