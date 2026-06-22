<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Support multiple roles: RoleMiddleware::class . ':admin,editor'
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                abort(403, 'Anda harus login terlebih dahulu.');
            }
            return redirect()->route('login');
        }

        // Cek role user
        $userRole = auth()->user()->role;

        // Jika tidak ada role yang diizinkan, lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah role user ada di daftar yang diizinkan
        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
            
            // Redirect ke halaman yang sesuai berdasarkan role
            if ($userRole === 'editor') {
                return redirect()->route('editor.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}