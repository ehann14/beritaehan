<?php

namespace App\Http\Controllers;

use App\Models\EditorApplication;
use App\Models\User;
use Illuminate\Http\Request;

class EditorApplicationController extends Controller
{
    // User mendaftar jadi editor
    public function create()
    {
        // Cek apakah user sudah punya aplikasi pending
        $existingApplication = EditorApplication::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            return redirect()->route('editor.application.status')
                ->with('info', 'Anda sudah memiliki pendaftaran yang sedang diproses.');
        }

        // Cek apakah user sudah jadi editor
        if (auth()->user()->role === 'editor') {
            return redirect()->route('editor.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai editor.');
        }

        return view('editor-application.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|min:10',
            'reason' => 'nullable|string|max:1000',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 10 karakter.',
        ]);

        // Cek apakah sudah ada aplikasi pending
        $existingApplication = EditorApplication::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah memiliki pendaftaran yang sedang diproses.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        EditorApplication::create($validated);

        return redirect()->route('editor.application.status')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu review dari admin.');
    }

    // User cek status pendaftaran
    public function status()
    {
        $application = EditorApplication::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('editor-application.status', compact('application'));
    }

    // Admin: lihat semua aplikasi
    public function adminIndex(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $filter = $request->input('filter', 'pending');

        $query = EditorApplication::with(['user', 'reviewer']);

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
        }

        $applications = $query->latest()->paginate(15);

        $totalPending = EditorApplication::pending()->count();
        $totalApproved = EditorApplication::approved()->count();
        $totalRejected = EditorApplication::rejected()->count();

        return view('admin.editor-applications', compact(
            'applications',
            'filter',
            'totalPending',
            'totalApproved',
            'totalRejected'
        ));
    }

    // Admin: approve aplikasi
    public function approve(EditorApplication $application)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Update status aplikasi
        $application->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        // Update role user jadi editor
        $application->user->update([
            'role' => 'editor',
        ]);

        return redirect()->route('admin.editor-applications.index')
            ->with('success', "Pendaftaran {$application->full_name} berhasil disetujui! User sekarang adalah editor.");
    }

    // Admin: reject aplikasi
    public function reject(Request $request, EditorApplication $application)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan minimal 10 karakter.',
        ]);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.editor-applications.index')
            ->with('success', "Pendaftaran {$application->full_name} telah ditolak.");
    }
}