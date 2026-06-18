<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Berita Terkini') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Jelajahi berita terbaru dari berbagai kategori.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Daftar Berita -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($posts as $post)
                    <article class="group bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden h-full flex flex-col">
                        @if($post->thumbnail)
                            <div class="relative aspect-video w-full overflow-hidden">
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @if($post->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white shadow-lg backdrop-blur-sm">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="relative aspect-video w-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @if($post->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white shadow-lg">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2 mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-tight">
                                {{ $post->title }}
                            </h3>

                            @if($post->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($post->tags->take(2) as $tag)
                                        <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-gray-800 px-2.5 py-1 text-xs font-medium text-slate-700 dark:text-slate-300">
                                            #{{ $tag->name }}
                                        </span>
                                    @endforeach
                                    @if($post->tags->count() > 2)
                                        <span class="text-xs text-slate-500 dark:text-slate-400 self-center">+{{ $post->tags->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-auto pt-4 border-t border-slate-200 dark:border-gray-800">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs text-gray-500 dark:text-gray-400 mb-4">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $post->created_at->format('d M Y') }}</span>
                                    </div>

                                    @if($post->author)
                                        <span class="text-slate-300 dark:text-gray-600">•</span>
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>{{ $post->author }}</span>
                                        </div>
                                    @endif

                                    <span class="text-slate-300 dark:text-gray-600">•</span>
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span>{{ $post->comments_count }} komentar</span>
                                    </div>
                                </div>

                                <a href="{{ route('posts.show', $post) }}"
                                   class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm group">
                                    Baca Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 px-4">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 dark:bg-gray-800 mb-4">
                            <svg class="w-10 h-10 text-slate-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada berita</h3>
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada berita yang ditemukan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>