<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        // Validasi
        $validated = $request->validate([
            'isi_komentar' => 'required|string|min:5|max:1000',
        ]);

        // Buat komentar dengan user_id dan nama otomatis dari user yang login
        $post->comments()->create([
            'user_id' => Auth::id(), // TAMBAHKAN INI
            'nama' => Auth::user()->name,
            'isi_komentar' => $validated['isi_komentar'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // 🔹 Method HAPUS KOMENTAR — hanya untuk admin
    public function destroy(Comment $comment): RedirectResponse
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menghapus komentar.');
        }

        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}