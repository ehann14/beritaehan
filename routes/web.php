<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EditorApplicationController;
use Illuminate\Support\Facades\Route;

// === 👮 HALAMAN ADMIN SAJA ===
Route::middleware([
    'auth',
    'verified',
    \App\Http\Middleware\RoleMiddleware::class . ':admin'
])->group(function () {
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
    Route::resource('posts', PostController::class)->except(['show']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // 🔹 Review Berita dari Editor
    Route::get('/admin/review', [PostController::class, 'reviewIndex'])->name('admin.review.index');
    Route::get('/admin/review/{post}', [PostController::class, 'reviewShow'])->name('admin.review.show');
    Route::post('/admin/review/{post}/approve', [PostController::class, 'reviewApprove'])->name('admin.review.approve');
    Route::post('/admin/review/{post}/reject', [PostController::class, 'reviewReject'])->name('admin.review.reject');
    
    // 🔹 Review Pendaftaran Editor
    Route::get('/admin/editor-applications', [EditorApplicationController::class, 'adminIndex'])->name('admin.editor-applications.index');
    Route::post('/admin/editor-applications/{application}/approve', [EditorApplicationController::class, 'approve'])->name('admin.editor-applications.approve');
    Route::post('/admin/editor-applications/{application}/reject', [EditorApplicationController::class, 'reject'])->name('admin.editor-applications.reject');
});

// === ✏️ HALAMAN EDITOR (Admin & Editor) ===
Route::middleware([
    'auth',
    'verified',
    \App\Http\Middleware\RoleMiddleware::class . ':admin,editor'
])->group(function () {
    Route::get('/editor/dashboard', [PostController::class, 'editorDashboard'])->name('editor.dashboard');
    Route::get('/editor/posts', [PostController::class, 'editorIndex'])->name('editor.posts.index');
    Route::get('/editor/posts/create', [PostController::class, 'editorCreate'])->name('editor.posts.create');
    Route::post('/editor/posts', [PostController::class, 'editorStore'])->name('editor.posts.store');
    Route::get('/editor/posts/{post}/edit', [PostController::class, 'editorEdit'])->name('editor.posts.edit');
    Route::put('/editor/posts/{post}', [PostController::class, 'editorUpdate'])->name('editor.posts.update');
    Route::delete('/editor/posts/{post}', [PostController::class, 'editorDestroy'])->name('editor.posts.destroy');
});

// === 📝 PENDAFTARAN EDITOR (User yang login) ===
Route::middleware(['auth'])->group(function () {
    Route::get('/editor-application', [EditorApplicationController::class, 'create'])->name('editor.application.create');
    Route::post('/editor-application', [EditorApplicationController::class, 'store'])->name('editor.application.store');
    Route::get('/editor-application/status', [EditorApplicationController::class, 'status'])->name('editor.application.status');
});

// === 🔓 HALAMAN PUBLIK ===
Route::get('/', [PostController::class, 'indexPublic'])->name('home');
Route::get('/berita', [PostController::class, 'indexPublic'])->name('berita.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

require __DIR__.'/auth.php';