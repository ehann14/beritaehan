<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- 🔹 KOLOM UTAMA: ISI BERITA -->
                <div class="lg:w-2/3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h1 class="text-3xl md:text-4xl font-extrabold mb-4 text-gray-900 dark:text-white">
                                {{ $post->title }}
                            </h1>

                            @if($post->thumbnail)
                                <div class="mb-6">
                                    <img src="{{ asset('storage/'.$post->thumbnail) }}" 
                                         alt="Thumbnail" 
                                         class="w-full h-auto rounded-lg object-cover">
                                </div>
                            @endif

                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex flex-wrap gap-2">
                                @if($post->category)
                                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200 px-2 py-1 rounded text-xs">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                @foreach($post->tags as $tag)
                                    <span class="bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200 px-2 py-1 rounded text-xs">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <strong class="text-gray-700 dark:text-gray-300">Penulis:</strong> 
                                <span class="ml-2 text-gray-700 dark:text-gray-300">
                                    {{ $post->author ?? 'Tidak diketahui' }}
                                </span>
                            </div>

                            <div class="prose prose-gray dark:prose-invert max-w-none mb-8 mt-6">
                                {!! nl2br(e($post->content)) !!}
                            </div>

                            <!-- ✅ BAGIAN KOMENTAR -->
                            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                                    Komentar ({{ $post->comments_count }})
                                </h3>

                                @if($post->comments->isNotEmpty())
                                    <div class="space-y-5">
                                        @foreach($post->comments as $comment)
                                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl relative">
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    {{ htmlspecialchars($comment->nama) }}
                                                </div>
                                                <div class="mt-2 text-gray-700 dark:text-gray-300">
                                                    {!! nl2br(e($comment->isi_komentar)) !!}
                                                </div>
                                                <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $comment->created_at->format('d M Y H:i') }}
                                                </div>

                                                <!-- 🔹 TOMBOL HAPUS (HANYA UNTUK ADMIN) -->
                                                @auth
                                                    @if(auth()->user()->role === 'admin')
                                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="absolute top-3 right-3">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    onclick="return confirm('Yakin hapus komentar ini?')"
                                                                    class="text-red-500 hover:text-red-700 text-sm font-medium">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">Belum ada komentar.</p>
                                @endif

                                <div class="mt-8">
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tinggalkan Komentar</h4>

                                    @if(session('success'))
                                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md dark:bg-green-900/30 dark:text-green-200">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('comments.store', $post) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <input type="text" name="nama" value="{{ old('nama') }}" 
                                                   placeholder="Nama (hanya huruf)" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                   required>
                                            @error('nama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="mb-6">
                                            <textarea name="isi_komentar" rows="4" 
                                                      placeholder="Tulis komentar Anda..." 
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                      required>{{ old('isi_komentar') }}</textarea>
                                            @error('isi_komentar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <button type="submit"
                                                class="px-6 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                                            Kirim Komentar
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Tombol kembali -->
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('berita.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    &larr; Kembali ke Daftar Berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🔹 SIDEBAR KANAN: BERITA TERKAIT -->
                <div class="lg:w-1/3">
                    @if($relatedPosts->isNotEmpty())
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 sticky top-24 hidden lg:block">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Berita Terkait</h3>
                            <div class="space-y-4">
                                @foreach($relatedPosts as $related)
                                    <a href="{{ route('posts.show', $related) }}" class="block group">
                                        <div class="flex gap-3">
                                            @if($related->thumbnail)
                                                <div class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden">
                                                    <img src="{{ asset('storage/'.$related->thumbnail) }}" 
                                                         alt="{{ $related->title }}"
                                                         class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white group-hover:text-teal-500 line-clamp-2 text-sm">
                                                    {{ $related->title }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $related->created_at->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>