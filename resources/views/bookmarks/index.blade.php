<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Berita Tersimpan (Bookmark)</h1>
                    <p class="text-gray-600">Daftar artikel yang Anda simpan untuk dibaca nanti</p>
                </div>
                <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    {{ $bookmarks->total() }} / 7 Tersimpan
                </div>
            </div>

            <!-- Notifikasi -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($bookmarks->count() > 0)
                <div class="space-y-4">
                    @foreach($bookmarks as $bookmark)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200 p-6">
                            <div class="flex items-start gap-4">
                                @if($bookmark->post->thumbnail)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $bookmark->post->thumbnail) }}" 
                                             alt="{{ $bookmark->post->title }}"
                                             class="w-32 h-24 object-cover rounded-lg">
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600">
                                        <a href="{{ route('posts.show', $bookmark->post) }}">
                                            {{ $bookmark->post->title }}
                                        </a>
                                    </h2>

                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-2">
                                        @if($bookmark->post->category)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                {{ $bookmark->post->category->name }}
                                            </span>
                                        @endif
                                        <span class="flex items-center">
                                            {{ $bookmark->post->created_at->format('d M Y') }}
                                        </span>
                                    </div>

                                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                        {{ Str::limit(strip_tags($bookmark->post->content), 150) }}
                                    </p>

                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-500">
                                            {{ $bookmark->post->author }}
                                        </div>
                                        
                                        <!-- Tombol Hapus Bookmark -->
                                        <form action="{{ route('posts.bookmark', $bookmark->post) }}" method="POST" onsubmit="return confirm('Hapus berita ini dari bookmark?')">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $bookmarks->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg shadow-md border border-gray-200">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Bookmark</h3>
                    <p class="text-gray-600 mb-6">Anda belum menyimpan artikel apapun.</p>
                    <a href="{{ route('berita.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Jelajahi Artikel
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>