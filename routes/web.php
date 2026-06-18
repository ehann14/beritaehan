<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// === 👮 HALAMAN ADMIN SAJA ===
Route::middleware([
    'auth',
    'verified',
    \App\Http\Middleware\RoleMiddleware::class . ':admin'
])->group(function () {
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
    
    // Resource: posts → menghasilkan:
    // GET    /posts               → index     → name: posts.index
    // GET    /posts/create        → create    → name: posts.create
    // POST   /posts               → store     → name: posts.store
    // GET    /posts/{post}/edit   → edit      → name: posts.edit
    // PUT    /posts/{post}        → update    → name: posts.update
    // DELETE /posts/{post}        → destroy   → name: posts.destroy
    Route::resource('posts', PostController::class)->except(['show']);
    
    // 🔹 Hapus komentar — hanya admin
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// === 🔓 HALAMAN PUBLIK ===
Route::get('/', [PostController::class, 'indexPublic'])->name('home');
Route::get('/berita', [PostController::class, 'indexPublic'])->name('berita.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// 🔹 Tambah komentar — publik
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

// === 🔐 HALAMAN PROFIL (user login & verified) ===
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';