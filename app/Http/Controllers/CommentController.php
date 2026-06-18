<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'isi_komentar' => 'required|string|min:5|max:1000',
        ], [
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
        ]);

        $post->comments()->create($validated);

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