<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Berita Terkini') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Daftar Berita -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
                @forelse($posts as $post)
                    <div class="flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition-shadow duration-300 overflow-hidden h-full">
                        @if($post->thumbnail)
                            <div class="aspect-video w-full overflow-hidden">
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                        @endif

                        <div class="p-4 sm:p-5 flex-grow flex flex-col">
                            @if($post->category)
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full mb-2">
                                    {{ $post->category->name }}
                                </span>
                            @endif

                            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white line-clamp-2 mb-3">
                                {{ $post->title }}
                            </h2>

                            <div class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $post->created_at->format('d M Y') }}
                                    </div>

                                    @if($post->author)
                                        <span>•</span>
                                        <span>oleh {{ $post->author }}</span>
                                    @endif

                                    <span>•</span>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        {{ $post->comments_count }}
                                    </div>
                                </div>

                                <a href="{{ route('posts.show', $post) }}"
                                   class="mt-3 inline-block w-full sm:w-auto text-center px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors group">
                                    Baca Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline ml-1 h-4 w-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 px-4">
                        <p class="text-gray-500 italic text-base sm:text-lg">Tidak ada berita yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 sm:mt-10">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>