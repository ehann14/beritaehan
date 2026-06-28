<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ringkasan statistik lengkap website Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 🔹 STATISTIK UTAMA (5 Kartu) --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5 mb-8">
                {{-- Total Berita --}}
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Berita</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($totalPosts) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('posts.index') }}" class="mt-5 inline-flex items-center text-sm font-semibold text-white/90 hover:text-white">
                            Lihat Semua
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                </div>

                {{-- Total User (Clickable ke Manajemen User) --}}
                <a href="{{ route('admin.users.index') }}" class="block group">
                    <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-500 shadow-lg shadow-emerald-200/20 transition-all duration-300 group-hover:shadow-xl group-hover:scale-[1.02]">
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
                            <div class="mt-5 flex items-center text-sm font-semibold text-white/90 group-hover:text-white transition-colors">
                                <span>Kelola User</span>
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Total Editor --}}
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
                        <p class="mt-5 text-sm text-white/80">Editor aktif</p>
                    </div>
                </div>

                {{-- Total Komentar --}}
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 to-orange-400 shadow-lg shadow-orange-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Komentar</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($totalComments) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-5 text-sm text-white/80">Komentar dari pembaca</p>
                    </div>
                </div>

                {{-- Total View Hari Ini --}}
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-500 to-red-400 shadow-lg shadow-red-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">View Hari Ini</p>
                                <p class="mt-4 text-4xl font-semibold">{{ number_format($totalViewsToday) }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-5 text-sm text-white/80">Dilihat hari ini</p>
                    </div>
                </div>
            </div>

            {{-- 🔹 STATISTIK KATEGORI & TAG --}}
            <div class="grid gap-6 lg:grid-cols-2 mb-8">
                {{-- Kategori dengan Jumlah Berita --}}
                <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden" x-data="{ showAll: false }">
                    <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7.5A2.5 2.5 0 015.5 5h13A2.5 2.5 0 0121 7.5v9A2.5 2.5 0 0118.5 19h-13A2.5 2.5 0 013 16.5v-9z" />
                                </svg>
                                Kategori Populer
                            </div>
                            @if($categoriesWithCount->count() > 0)
                                <button @click="showAll = !showAll" 
                                        class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium flex items-center gap-1 transition">
                                    <span x-text="showAll ? 'Sembunyikan' : 'Tampilkan ({{ $categoriesWithCount->count() }})'"></span>
                                    <svg x-show="!showAll" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <svg x-show="showAll" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                            @endif
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($categoriesWithCount->count() > 0)
                            <div class="space-y-3">
                                @foreach($categoriesWithCount as $index => $category)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-emerald-50 to-white dark:from-emerald-900/20 dark:to-gray-800 border border-emerald-100 dark:border-emerald-800 transition-all duration-300"
                                         x-show="showAll"
                                         x-transition>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($category->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Kategori</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $category->posts_count }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">berita</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada kategori</p>
                        @endif
                    </div>
                </div>

                {{-- Tag dengan Jumlah Berita --}}
                <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden" x-data="{ showAll: false }">
                    <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l10 10" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7H7v10" />
                                </svg>
                                Tag Populer
                            </div>
                            @if($tagsWithCount->count() > 0)
                                <button @click="showAll = !showAll" 
                                        class="text-sm text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 font-medium flex items-center gap-1 transition">
                                    <span x-text="showAll ? 'Sembunyikan' : 'Tampilkan ({{ $tagsWithCount->count() }})'"></span>
                                    <svg x-show="!showAll" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <svg x-show="showAll" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                            @endif
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($tagsWithCount->count() > 0)
                            <div class="space-y-3">
                                @foreach($tagsWithCount as $index => $tag)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-orange-50 to-white dark:from-orange-900/20 dark:to-gray-800 border border-orange-100 dark:border-orange-800 transition-all duration-300"
                                         x-show="showAll"
                                         x-transition>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-orange-500 flex items-center justify-center text-white font-bold">
                                                #{{ strtoupper(substr($tag->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $tag->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Tag</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $tag->posts_count }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">berita</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada tag</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 🔹 TABEL BERITA --}}
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div class="min-w-0 flex-1">
                            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                                <label for="search" class="sr-only">Cari Berita</label>
                                <div class="relative w-full">
                                    <input id="search" name="search" value="{{ request('search') }}" type="search" placeholder="Cari judul, penulis, kategori..."
                                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20" />
                                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400 dark:text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.65 9.65a7.5 7.5 0 0012.7 6.7z" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <a href="{{ route('posts.create') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            + Tambah Berita
                        </a>
                    </div>

                    @if(request('search'))
                        <div class="mb-6 rounded-2xl bg-sky-50 p-4 text-sm text-sky-700 dark:bg-sky-950/40 dark:text-sky-200">
                            Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-gray-800">
                            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-600 dark:bg-gray-900 dark:text-slate-400">
                                <tr>
                                    <th class="px-4 py-4">Thumbnail</th>
                                    <th class="px-4 py-4">Judul</th>
                                    <th class="px-4 py-4">Penulis</th>
                                    <th class="px-4 py-4">Kategori</th>
                                    <th class="px-4 py-4">Tag</th>
                                    <th class="px-4 py-4">Tanggal</th>
                                    <th class="px-4 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white dark:divide-gray-800 dark:bg-gray-950">
                                @forelse($posts as $post)
                                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900/80">
                                        <td class="px-4 py-4 align-middle whitespace-nowrap">
                                            @if($post->thumbnail)
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="h-16 w-16 rounded-2xl object-cover" />
                                            @else
                                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-sm text-slate-500 dark:bg-gray-800 dark:text-slate-400">
                                                    —
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle">
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $post->title }}</div>
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $post->author ?? '—' }}</td>
                                        <td class="px-4 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $post->category ? $post->category->name : '—' }}</td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            @if($post->tags->isNotEmpty())
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($post->tags as $tag)
                                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">#{{ $tag->name }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-slate-500 dark:text-slate-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $post->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('posts.show', $post) }}" class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">Lihat</a>
                                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                                                    <a href="{{ route('posts.edit', $post) }}" class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 transition hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-200 dark:hover:bg-amber-500/20">Edit</a>
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Yakin hapus berita ini?')" class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 dark:hover:bg-red-500/20">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                            Tidak ada berita yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>