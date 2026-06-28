<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Membaca</h1>
                <p class="text-gray-600">Daftar artikel yang pernah Anda baca</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($histories->count() > 0)
                <!-- Clear History Button -->
                <div class="mb-6 flex justify-end">
                    <form action="{{ route('reading-history.clear') }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua riwayat baca?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Hapus Riwayat
                        </button>
                    </form>
                </div>

                <!-- Reading History List -->
                <div class="space-y-4">
                    @foreach($histories as $history)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <!-- Thumbnail -->
                                    @if($history->post->thumbnail)
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . $history->post->thumbnail) }}" 
                                                 alt="{{ $history->post->title }}"
                                                 class="w-32 h-24 object-cover rounded-lg">
                                        </div>
                                    @endif

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <!-- Title -->
                                        <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600">
                                            <a href="{{ route('posts.show', $history->post) }}">
                                                {{ $history->post->title }}
                                            </a>
                                        </h2>

                                        <!-- Meta Info -->
                                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-2">
                                            @if($history->post->category)
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                    {{ $history->post->category->name }}
                                                </span>
                                            @endif
                                            
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ $history->post->created_at->format('d M Y') }}
                                            </span>

                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Dibaca: {{ $history->viewed_at->diffForHumans() }}
                                            </span>
                                        </div>

                                        <!-- Excerpt -->
                                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                            {{ Str::limit(strip_tags($history->post->content), 150) }}
                                        </p>

                                        <!-- Author -->
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            {{ $history->post->author }}
                                        </div>
                                    </div>

                                    <!-- Arrow -->
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $histories->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 bg-white rounded-lg shadow-md border border-gray-200">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Baca</h3>
                    <p class="text-gray-600 mb-6">Anda belum membaca artikel apapun. Jelajahi artikel kami untuk memulai!</p>
                    <a href="{{ route('berita.index') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Jelajahi Artikel
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>