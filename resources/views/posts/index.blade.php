<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Kelola Berita') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola semua berita, artikel, dan konten Anda.</p>
            </div>
            <a href="{{ route('posts.create') }}"
               class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Berita
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- 📊 Statistik Cards -->
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3 mb-8">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Berita</p>
                                <p class="mt-4 text-4xl font-semibold">{{ $totalPosts }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-500 shadow-lg shadow-emerald-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Kategori</p>
                                <p class="mt-4 text-4xl font-semibold">{{ $totalCategories }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7.5A2.5 2.5 0 015.5 5h13A2.5 2.5 0 0121 7.5v9A2.5 2.5 0 0118.5 19h-13A2.5 2.5 0 013 16.5v-9z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-yellow-500 to-orange-400 shadow-lg shadow-yellow-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Total Tag</p>
                                <p class="mt-4 text-4xl font-semibold">{{ $totalTags }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l10 10" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7H7v10" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div class="min-w-0 flex-1">
                            <form method="GET" action="{{ route('posts.index') }}" class="flex items-center gap-2">
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
                    </div>

                    @if(request('search'))
                        <div class="mb-6 rounded-2xl bg-sky-50 p-4 text-sm text-sky-700 dark:bg-sky-950/40 dark:text-sky-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
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
                                    <th class="px-4 py-4">Status</th>
                                    <th class="px-4 py-4">Tanggal</th>
                                    <th class="px-4 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white dark:divide-gray-800 dark:bg-gray-950">
                                @forelse($posts as $post)
                                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900/80">
                                        <td class="px-4 py-4 align-middle whitespace-nowrap">
                                            @if($post->thumbnail)
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="h-16 w-16 rounded-2xl object-cover shadow" />
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
                                        <td class="px-4 py-4 align-middle text-sm">
                                            @if($post->category)
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                                    {{ $post->category->name }}
                                                </span>
                                            @else
                                                <span class="text-slate-500 dark:text-slate-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            @if($post->tags->isNotEmpty())
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($post->tags->take(3) as $tag)
                                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">#{{ $tag->name }}</span>
                                                    @endforeach
                                                    @if($post->tags->count() > 3)
                                                        <span class="text-xs text-slate-500">+{{ $post->tags->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-slate-500 dark:text-slate-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            @if($post->status === 'published')
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $post->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </a>
                                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                                                    <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 transition hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-200 dark:hover:bg-amber-500/20">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Yakin hapus berita ini?')" class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 dark:hover:bg-red-500/20">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-10 text-center">
                                            <div class="text-slate-500 dark:text-slate-400">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="mt-2 text-sm">Tidak ada berita yang ditemukan.</p>
                                            </div>
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