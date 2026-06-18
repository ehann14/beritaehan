<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    private function ensureAdmin()
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }

    public function dashboard()
    {
        $this->ensureAdmin();
        
        $totalPosts = Post::count();
        $totalCategories = Category::count();
        $totalTags = Tag::count();
        
        $posts = Post::with(['category', 'tags'])->latest()->paginate(15);
        
        return view('dashboard', compact('posts', 'totalPosts', 'totalCategories', 'totalTags'));
    }

    public function index(Request $request)
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Post::with(['category', 'tags'])->latest();

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15);

        $totalPosts = Post::count();
        $totalCategories = Category::count();
        $totalTags = Tag::count();

        return view('posts.index', compact('posts', 'totalPosts', 'totalCategories', 'totalTags'));
    }

    public function indexPublic(Request $request)
    {
        $query = Post::with(['category', 'tags'])->withCount('comments');

        if ($categoryName = $request->input('category')) {
            $category = Category::where('name', $categoryName)->first();
        if ($category) {
            $query->where('category_id', $category->id);
            }
        }

        if ($request->input('sort') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->latest();
        }

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15);

        return view('berita.index', compact('posts'));
    }

    public function create()
    {
        $this->ensureAdmin();
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'author'      => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->only(['title', 'content', 'author', 'category_id']);

        if ($request->hasFile('thumbnail')) {
            $destinationPath = public_path('storage/thumbnails');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move($destinationPath, $filename);

            $data['thumbnail'] = 'thumbnails/' . $filename;
        }

        $post = Post::create($data);
        $post->tags()->sync($request->tags ?? []);

        // 🔥 INI YANG DIUBAH: posts.index, BUKAN admin.posts.index
        return redirect()->route('posts.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Post $post)
    {
        $post->load(['category', 'tags', 'comments']);

        $popularPosts = Post::where('id', '!=', $post->id)
            ->with(['category', 'tags'])
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                if ($post->category_id) {
                    $query->where('category_id', $post->category_id);
                }
                if ($post->tags->isNotEmpty()) {
                    $tagIds = $post->tags->pluck('id')->toArray();
                    $query->orWhereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tags.id', $tagIds);
                    });
                }
            })
            ->with(['category', 'tags'])
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.show', compact('post', 'popularPosts', 'relatedPosts'));
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $post = Post::with(['category', 'tags'])->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureAdmin();

        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'author'      => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $post = Post::findOrFail($id);
        $data = $request->only(['title', 'content', 'author', 'category_id']);

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                $oldPath = public_path('storage/' . $post->thumbnail);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $destinationPath = public_path('storage/thumbnails');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move($destinationPath, $filename);

            $data['thumbnail'] = 'thumbnails/' . $filename;
        }

        $post->update($data);
        $post->tags()->sync($request->tags ?? []);

        // 🔥 INI YANG DIUBAH
        return redirect()->route('posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $this->ensureAdmin();

        if ($post->thumbnail) {
            $path = public_path('storage/' . $post->thumbnail);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $post->tags()->detach();
        $post->delete();

        // 🔥 INI YANG DIUBAH
        return redirect()->route('posts.index')->with('success', 'Berita berhasil dihapus!');
    }
}