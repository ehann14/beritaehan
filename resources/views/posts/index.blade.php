<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- 📊 Statistik Cards — SEJAJAR -->
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <div class="bg-blue-500 text-white p-5 rounded-xl shadow-lg flex-1 min-w-0">
                    <h3 class="text-sm font-medium uppercase tracking-wide">TOTAL BERITA</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalPosts }}</p>
                    <a href="{{ route('posts.index') }}" class="mt-3 text-sm underline">Lihat Semua</a>
                </div>
                <div class="bg-green-500 text-white p-5 rounded-xl shadow-lg flex-1 min-w-0">
                    <h3 class="text-sm font-medium uppercase tracking-wide">TOTAL KATEGORI</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalCategories }}</p>
                    <span class="mt-3 text-sm opacity-90">Kelola di Berita</span>
                </div>
                <div class="bg-yellow-500 text-white p-5 rounded-xl shadow-lg flex-1 min-w-0">
                    <h3 class="text-sm font-medium uppercase tracking-wide">TOTAL TAG</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalTags }}</p>
                    <span class="mt-3 text-sm opacity-90">Kelola di Berita</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-6 p-3 bg-green-100 text-green-800 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ request()->url() }}" class="mb-6">
                        <div class="flex gap-2">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari berita..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Cari
                            </button>
                        </div>
                    </form>

                    @if(request('search'))
                        <div class="mb-6 p-3 bg-blue-100 text-blue-800 rounded">
                            Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                        </div>
                    @endif

                    <div class="flex justify-end mb-6">
                        <a href="{{ route('posts.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-blue-700">
                            + Tambah Berita
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Thumbnail</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Penulis</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kategori</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tag</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($posts as $post)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($post->thumbnail)
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                                     alt="{{ $post->title }}"
                                                     class="h-16 w-16 object-cover rounded">
                                            @else
                                                <div class="h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-gray-500">—</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $post->title }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $post->author ?? '—' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $post->category ? $post->category->name : '—' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if($post->tags->isNotEmpty())
                                                @foreach($post->tags as $tag)
                                                    <span class="inline-block bg-gray-200 dark:bg-gray-700 text-xs px-2 py-0.5 rounded mr-1 mt-1">#{{ $tag->name }}</span>
                                                @endforeach
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $post->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col gap-1">
                                                <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200">Lihat</a>
                                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                                                    <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200">Edit</a>
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Yakin hapus berita ini?')" class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                            Tidak ada berita yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>