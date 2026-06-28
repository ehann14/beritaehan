<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    private function ensureAdmin()
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }

    // ========================================
    // 🔹 RIWAYAT WARNING USER (BARU)
    // ========================================
    
    public function myWarnings()
    {
        $user = auth()->user();
        
        $warnings = $user->warnings()
            ->with('admin')
            ->latest()
            ->paginate(10);

        return view('user.warnings', compact('warnings'));
    }

    // ========================================
    // 🔹 LIST SEMUA USER (KECUALI ADMIN)
    // ========================================

    public function index(Request $request)
    {
        $this->ensureAdmin();

        // Query user KECUALI yang role-nya admin
        $query = User::where('role', '!=', 'admin')
                     ->withCount(['posts', 'comments', 'warnings'])
                     ->latest();

        // Filter berdasarkan role (hanya user dan editor)
        if ($role = $request->input('role')) {
            if (in_array($role, ['user', 'editor'])) {
                $query->where('role', $role);
            }
        }

        // Filter berdasarkan status warning
        if ($request->input('has_warnings')) {
            $query->has('warnings');
        }

        // Search
        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        // Statistik (hanya user dan editor)
        $totalUsers = User::where('role', 'user')->count();
        $totalEditors = User::where('role', 'editor')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $usersWithWarnings = User::where('role', '!=', 'admin')->has('warnings')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalEditors',
            'totalAdmins',
            'usersWithWarnings'
        ));
    }

    // ========================================
    // 🔹 DETAIL USER
    // ========================================

    public function show(User $user)
    {
        $this->ensureAdmin();

        // Cek jika user yang dilihat adalah admin
        if ($user->role === 'admin') {
            abort(403, 'Akses ditolak. Detail admin tidak dapat dilihat.');
        }

        $user->loadCount(['posts', 'comments', 'warnings', 'bookmarks', 'readingHistories']);
        
        $warnings = $user->warnings()
            ->with('admin')
            ->latest()
            ->paginate(10);

        $recentPosts = $user->posts()
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        $recentComments = $user->comments()
            ->with('post')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.users.show', compact('user', 'warnings', 'recentPosts', 'recentComments'));
    }

    // ========================================
    // 🔹 BERI PERINGATAN
    // ========================================

    public function warn(Request $request, User $user)
    {
        $this->ensureAdmin();

        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat memberi peringatan kepada admin.');
        }

        $validated = $request->validate([
            'type' => 'required|in:warning,suspend,ban',
            'reason' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'expires_at' => 'nullable|date|after:now',
        ], [
            'type.required' => 'Jenis peringatan wajib dipilih.',
            'reason.required' => 'Alasan wajib diisi.',
            'message.required' => 'Pesan peringatan wajib diisi.',
            'message.min' => 'Pesan peringatan minimal 10 karakter.',
        ]);

        Warning::create([
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'type' => $validated['type'],
            'reason' => $validated['reason'],
            'message' => $validated['message'],
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        $typeLabel = [
            'warning' => 'Peringatan',
            'suspend' => 'Suspensi',
            'ban' => 'Banned',
        ];

        return back()->with('success', "{$typeLabel[$validated['type']]} berhasil diberikan kepada {$user->name}.");
    }

    // ========================================
    // 🔹 HAPUS PERINGATAN
    // ========================================

    public function removeWarning(Warning $warning)
    {
        $this->ensureAdmin();

        $warning->delete();

        return back()->with('success', 'Peringatan berhasil dihapus.');
    }

    // ========================================
    // 🔹 HAPUS USER
    // ========================================

    public function destroy(User $user)
    {
        $this->ensureAdmin();

        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Hapus profile photo jika ada
        if ($user->profile_photo) {
            $path = public_path('storage/' . $user->profile_photo);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // Hapus semua data terkait (cascade)
        $user->posts()->delete();
        $user->comments()->delete();
        $user->bookmarks()->delete();
        $user->readingHistories()->delete();
        $user->warnings()->delete();

        // Hapus user
        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$userName} berhasil dihapus beserta semua datanya.");
    }

    // ========================================
    // 🔹 UBAH ROLE USER
    // ========================================

    public function changeRole(Request $request, User $user)
    {
        $this->ensureAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat mengubah role akun sendiri.');
        }

        // Tidak bisa mengubah role admin menjadi non-admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah role akun admin.');
        }

        $validated = $request->validate([
            'role' => 'required|in:user,editor,admin',
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }
}