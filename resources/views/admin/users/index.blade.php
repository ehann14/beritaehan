<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 rounded-xl bg-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-gray-700 dark:text-slate-200 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                </div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    Manajemen User
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola semua user yang terdaftar di website.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 🔹 STATISTIK USER --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total User</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($totalUsers) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 to-purple-500 shadow-lg shadow-purple-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Editor</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($totalEditors) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-600 to-red-500 shadow-lg shadow-red-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Admin</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($totalAdmins) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 to-orange-400 shadow-lg shadow-orange-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">User dengan Warning</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($usersWithWarnings) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔹 FILTER & SEARCH --}}
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-700 dark:bg-red-900/30 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-4 lg:flex-row lg:items-center">
                        <div class="flex-1">
                            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20" />
                        </div>

                        <select name="role" class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20">
                            <option value="">Semua Role</option>
                            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                            <option value="editor" {{ request('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                        </select>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="has_warnings" value="1" {{ request('has_warnings') ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                            <span class="text-sm text-gray-700 dark:text-gray-300">Dengan Warning</span>
                        </label>

                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            Filter
                        </button>
                    </form>
                </div>

                {{-- 🔹 TABEL USER --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-gray-800">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-600 dark:bg-gray-900 dark:text-slate-400">
                            <tr>
                                <th class="px-6 py-4 font-semibold">User</th>
                                <th class="px-6 py-4 font-semibold">Email</th>
                                <th class="px-6 py-4 font-semibold">Role</th>
                                <th class="px-6 py-4 font-semibold text-center">Posts</th>
                                <th class="px-6 py-4 font-semibold text-center">Komentar</th>
                                <th class="px-6 py-4 font-semibold text-center">Warning</th>
                                <th class="px-6 py-4 font-semibold">Terdaftar</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-gray-800 dark:bg-gray-950">
                            @forelse($users as $user)
                                <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900/80">
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700" />
                                            @else
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-500 text-white font-bold text-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $user->email }}</td>
                                    <td class="px-6 py-4 align-middle">
                                        @if($user->role === 'admin')
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-500/20 dark:text-red-300 border border-red-200 dark:border-red-500/30">
                                                Admin
                                            </span>
                                        @elseif($user->role === 'editor')
                                            <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700 dark:bg-purple-500/20 dark:text-purple-300 border border-purple-200 dark:border-purple-500/30">
                                                Editor
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300 border border-blue-200 dark:border-blue-500/30">
                                                User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-slate-700 dark:text-slate-300 text-center font-medium">{{ $user->posts_count }}</td>
                                    <td class="px-6 py-4 align-middle text-sm text-slate-700 dark:text-slate-300 text-center font-medium">{{ $user->comments_count }}</td>
                                    <td class="px-6 py-4 align-middle text-center">
                                        @if($user->warnings_count > 0)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-red-500 text-white text-xs font-bold shadow-lg shadow-orange-500/30 dark:shadow-orange-600/40" title="{{ $user->warnings_count }} Warning Aktif">
                                                {{ $user->warnings_count }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 dark:text-slate-600 text-sm">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                                                Detail
                                            </a>
                                            @if($user->role !== 'admin' && $user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Yakin ingin menghapus akun {{ $user->name }}? Semua data akan dihapus permanen!')" 
                                                            class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 dark:hover:bg-red-500/20">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-500 dark:text-slate-400">
                                            <svg class="w-16 h-16 mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-lg font-medium">Tidak ada user yang ditemukan</p>
                                            <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-800">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>