<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ReadingHistory;
use App\Models\Bookmark;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostController extends Controller
{
    private function ensureAdmin()
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }

    private function ensureCanManagePosts()
    {
        if (! auth()->check() || ! auth()->user()->canManagePosts()) {
            abort(403, 'Akses ditolak. Hanya admin atau editor yang diizinkan.');
        }
    }

    // ========================================
    // 🔹 ADMIN METHODS
    // ========================================

    public function dashboard(Request $request)
    {
        $this->ensureAdmin();
        
        // Statistik Utama
        $totalPosts = Post::count();
        $totalCategories = Category::count();
        $totalTags = Tag::count();
        $totalPending = Post::pending()->count();
        
        // Statistik Tambahan - HITUNG SEMUA USER NON-ADMIN
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalEditors = User::where('role', 'editor')->count();
        $totalComments = Comment::count();
        $totalViewsToday = ReadingHistory::whereDate('viewed_at', Carbon::today())->count();
        
        $categoriesWithCount = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();
        
        $tagsWithCount = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();
        
        $query = Post::with(['user', 'category', 'tags'])->latest();

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15);
        
        return view('dashboard', compact(
            'posts', 
            'totalPosts', 
            'totalCategories', 
            'totalTags',
            'totalPending',
            'totalUsers',
            'totalEditors',
            'totalComments',
            'totalViewsToday',
            'categoriesWithCount',
            'tagsWithCount'
        ));
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = Post::with(['user', 'category', 'tags'])->latest();

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15);

        $totalPosts = Post::count();
        $totalCategories = Category::count();
        $totalTags = Tag::count();

        return view('posts.index', compact('posts', 'totalPosts', 'totalCategories', 'totalTags'));
    }

    public function create()
    {
        $this->ensureCanManagePosts();
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'author'      => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'status'      => 'required|in:draft,published',
        ], [
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format yang diperbolehkan: jpeg, png, jpg, gif, webp.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $data = $request->only(['title', 'content', 'author', 'category_id']);
        $data['user_id'] = auth()->id();

        if (empty($data['author'])) {
            $data['author'] = auth()->user()->name;
        }

        $data['slug'] = Str::slug($validated['title']);
        $data['status'] = $validated['status'];
        
        $data['review_status'] = 'approved';
        $data['reviewed_by'] = auth()->id();
        $data['reviewed_at'] = now();

        if ($validated['status'] === 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                
                if (!$file->isValid()) {
                    return back()->withErrors(['thumbnail' => 'File upload tidak valid. Silakan coba lagi.']);
                }

                $destinationPath = public_path('storage/thumbnails');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                $data['thumbnail'] = 'thumbnails/' . $filename;
                
            } catch (\Exception $e) {
                return back()->withErrors(['thumbnail' => 'Gagal upload gambar: ' . $e->getMessage()]);
            }
        }

        $post = Post::create($data);
        $post->tags()->sync($request->tags ?? []);

        $message = $post->status === 'published' 
            ? 'Berita berhasil dipublish!' 
            : 'Berita berhasil disimpan sebagai draft!';

        return redirect()->route('posts.index')->with('success', $message);
    }

    public function edit($id)
    {
        $this->ensureCanManagePosts();
        $post = Post::with(['category', 'tags'])->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'author'      => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'status'      => 'required|in:draft,published',
        ], [
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format yang diperbolehkan: jpeg, png, jpg, gif, webp.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $post = Post::findOrFail($id);
        $data = $request->only(['title', 'content', 'author', 'category_id']);

        if (empty($data['author'])) {
            $data['author'] = auth()->user()->name;
        }

        if ($validated['title'] !== $post->title) {
            $data['slug'] = Str::slug($validated['title']);
        }

        $data['status'] = $validated['status'];

        if ($validated['status'] === 'published' && $post->status === 'draft') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                
                if (!$file->isValid()) {
                    return back()->withErrors(['thumbnail' => 'File upload tidak valid. Silakan coba lagi.']);
                }

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

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                $data['thumbnail'] = 'thumbnails/' . $filename;
                
            } catch (\Exception $e) {
                return back()->withErrors(['thumbnail' => 'Gagal upload gambar: ' . $e->getMessage()]);
            }
        }

        $post->update($data);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $this->ensureCanManagePosts();

        if ($post->thumbnail) {
            $path = public_path('storage/' . $post->thumbnail);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Berita berhasil dihapus!');
    }

    // ========================================
    // 🔹 EDITOR METHODS
    // ========================================

    public function editorDashboard(Request $request)
    {
        $this->ensureCanManagePosts();
        
        $userId = auth()->id();
        
        $totalPosts = Post::where('user_id', $userId)->count();
        $totalPublished = Post::where('user_id', $userId)->approved()->count();
        $totalPending = Post::where('user_id', $userId)->pending()->count();
        $totalRejected = Post::where('user_id', $userId)->rejected()->count();
        $totalDraft = Post::where('user_id', $userId)->where('status', 'draft')->count();
        
        $query = Post::where('user_id', $userId)
                     ->with(['category', 'tags'])
                     ->latest();

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(10);
        
        return view('editor.dashboard', compact(
            'posts', 
            'totalPosts', 
            'totalPublished',
            'totalPending',
            'totalRejected',
            'totalDraft'
        ));
    }

    public function editorIndex(Request $request)
    {
        $this->ensureCanManagePosts();
        
        $userId = auth()->id();

        $query = Post::where('user_id', $userId)
                     ->with(['category', 'tags', 'reviewer'])
                     ->latest();

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15);

        return view('editor.posts.index', compact('posts'));
    }

    public function editorCreate()
    {
        $this->ensureCanManagePosts();
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('editor.posts.create', compact('categories', 'tags'));
    }

    public function editorStore(Request $request)
    {
        $this->ensureCanManagePosts();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'author'      => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ], [
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format yang diperbolehkan: jpeg, png, jpg, gif, webp.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $data = $request->only(['title', 'content', 'author', 'category_id']);
        $data['user_id'] = auth()->id();

        if (empty($data['author'])) {
            $data['author'] = auth()->user()->name;
        }

        $data['slug'] = Str::slug($validated['title']);
        
        $data['status'] = 'draft';
        $data['review_status'] = 'pending';
        $data['rejection_reason'] = null;
        $data['reviewed_by'] = null;
        $data['reviewed_at'] = null;

        if ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                
                if (!$file->isValid()) {
                    return back()->withErrors(['thumbnail' => 'File upload tidak valid. Silakan coba lagi.']);
                }

                $destinationPath = public_path('storage/thumbnails');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                $data['thumbnail'] = 'thumbnails/' . $filename;
                
            } catch (\Exception $e) {
                return back()->withErrors(['thumbnail' => 'Gagal upload gambar: ' . $e->getMessage()]);
            }
        }

        $post = Post::create($data);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('editor.posts.index')
                        ->with('success', 'Berita berhasil dikirim untuk direview oleh admin!');
    }

    public function editorEdit(Post $post)
    {
        $this->ensureCanManagePosts();
        
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit berita ini.');
        }
        
        if ($post->review_status === 'approved') {
            return redirect()->route('editor.posts.index')
                            ->with('error', 'Berita yang sudah disetujui tidak dapat diedit.');
        }
        
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('editor.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function editorUpdate(Request $request, Post $post)
    {
        $this->ensureCanManagePosts();
        
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate berita ini.');
        }

        if ($post->review_status === 'approved') {
            return redirect()->route('editor.posts.index')
                            ->with('error', 'Berita yang sudah disetujui tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'author'      => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ], [
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format yang diperbolehkan: jpeg, png, jpg, gif, webp.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $data = $request->only(['title', 'content', 'author', 'category_id']);

        if (empty($data['author'])) {
            $data['author'] = auth()->user()->name;
        }

        if ($validated['title'] !== $post->title) {
            $data['slug'] = Str::slug($validated['title']);
        }

        $data['review_status'] = 'pending';
        $data['rejection_reason'] = null;
        $data['reviewed_by'] = null;
        $data['reviewed_at'] = null;
        $data['status'] = 'draft';

        if ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                
                if (!$file->isValid()) {
                    return back()->withErrors(['thumbnail' => 'File upload tidak valid. Silakan coba lagi.']);
                }

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

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                $data['thumbnail'] = 'thumbnails/' . $filename;
                
            } catch (\Exception $e) {
                return back()->withErrors(['thumbnail' => 'Gagal upload gambar: ' . $e->getMessage()]);
            }
        }

        $post->update($data);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('editor.posts.index')
                        ->with('success', 'Berita berhasil diperbarui dan dikirim ulang untuk review!');
    }

    public function editorDestroy(Post $post)
    {
        $this->ensureCanManagePosts();
        
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus berita ini.');
        }

        if ($post->thumbnail) {
            $path = public_path('storage/' . $post->thumbnail);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('editor.posts.index')->with('success', 'Berita berhasil dihapus!');
    }

    // ========================================
    // 🔹 ADMIN REVIEW METHODS
    // ========================================

    public function reviewIndex(Request $request)
    {
        $this->ensureAdmin();

        $filter = $request->input('filter', 'pending');

        $query = Post::with(['user', 'category', 'tags', 'reviewer']);

        switch ($filter) {
            case 'pending':
                $query->pending();
                break;
            case 'approved':
                $query->approved();
                break;
            case 'rejected':
                $query->rejected();
                break;
            default:
                break;
        }

        $posts = $query->latest()->paginate(15);

        $totalPending = Post::pending()->count();
        $totalApproved = Post::approved()->count();
        $totalRejected = Post::rejected()->count();

        return view('admin.review', compact(
            'posts', 
            'filter', 
            'totalPending', 
            'totalApproved', 
            'totalRejected'
        ));
    }

    public function reviewShow(Post $post)
    {
        $this->ensureAdmin();
        $post->load(['user', 'category', 'tags', 'reviewer']);
        return view('admin.review-show', compact('post'));
    }

    public function reviewApprove(Post $post)
    {
        $this->ensureAdmin();

        $post->update([
            'review_status' => 'approved',
            'status' => 'published',
            'published_at' => $post->published_at ?? now(),
            'rejection_reason' => null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.review.index')
                        ->with('success', "Berita \"{$post->title}\" berhasil disetujui dan dipublish!");
    }

    public function reviewReject(Request $request, Post $post)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $post->update([
            'review_status' => 'rejected',
            'status' => 'draft',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.review.index')
                        ->with('success', "Berita \"{$post->title}\" telah ditolak.");
    }

    // ========================================
    // 🔹 PUBLIC METHODS
    // ========================================

    public function indexPublic(Request $request)
    {
        $query = Post::published()
                     ->with(['user', 'category', 'tags'])
                     ->withCount('comments');

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

    public function show(Post $post)
    {
        if ($post->review_status !== 'approved') {
            abort(404);
        }

        // Track reading history
        if (auth()->check()) {
            ReadingHistory::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                ],
                ['viewed_at' => now()]
            );
            $this->limitReadingHistory(auth()->id(), 15);
        }

        // Cek status bookmark untuk user yang login
        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = Bookmark::where('user_id', auth()->id())
                                    ->where('post_id', $post->id)
                                    ->exists();
        }

        $post->load(['user', 'category', 'tags', 'comments.user']);

        $popularPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->with(['user', 'category', 'tags'])
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
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
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.show', compact('post', 'popularPosts', 'relatedPosts', 'isBookmarked'));
    }

    // ========================================
    // 🔹 BOOKMARK METHODS
    // ========================================

    public function toggleBookmark(Post $post)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menyimpan berita.');
        }

        $bookmark = Bookmark::where('user_id', auth()->id())
                            ->where('post_id', $post->id)
                            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', 'Berita berhasil dihapus dari bookmark.');
        } else {
            $currentBookmarks = Bookmark::where('user_id', auth()->id())->count();
            
            if ($currentBookmarks >= 7) {
                return back()->with('error', 'Maaf penyimpanan berita anda penuh.');
            }

            Bookmark::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            return back()->with('success', 'Berita berhasil disimpan ke bookmark.');
        }
    }

    public function bookmarks()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with(['post.user', 'post.category'])
            ->latest()
            ->paginate(10);

        return view('bookmarks.index', compact('bookmarks'));
    }

    // ========================================
    // 🔹 READING HISTORY METHODS
    // ========================================

    public function readingHistory()
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login untuk melihat riwayat baca.');
        }

        $histories = ReadingHistory::where('user_id', auth()->id())
            ->with(['post.user', 'post.category', 'post.tags'])
            ->latest('viewed_at')
            ->paginate(20);

        return view('reading-history.index', compact('histories'));
    }

    public function clearReadingHistory()
    {
        ReadingHistory::where('user_id', auth()->id())->delete();
        
        return redirect()->route('reading-history.index')
            ->with('success', 'Riwayat baca berhasil dihapus.');
    }

    private function limitReadingHistory($userId, $limit = 15)
    {
        $count = ReadingHistory::where('user_id', $userId)->count();
        
        if ($count > $limit) {
            $idsToDelete = ReadingHistory::where('user_id', $userId)
                ->oldest('viewed_at')
                ->limit($count - $limit)
                ->pluck('id');
            
            ReadingHistory::whereIn('id', $idsToDelete)->delete();
        }
    }
}