<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Detail Berita') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Baca lengkap berita dan tinggalkan komentar Anda.</p>
            </div>
            <a href="{{ route('berita.index') }}" 
               class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                <span class="mr-2">←</span> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- KOLOM UTAMA: ISI BERITA -->
                <div class="lg:w-2/3">
                    <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                        <div class="p-8">
                            <h1 class="text-3xl md:text-4xl font-extrabold mb-4 text-gray-900 dark:text-white leading-tight">
                                {{ $post->title }}
                            </h1>

                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400 mb-6">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $post->created_at->format('d M Y') }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $post->author ?? 'Tidak diketahui' }}
                                </span>
                            </div>

                            @if($post->thumbnail)
                                <div class="mb-8">
                                    <img src="{{ asset('storage/'.$post->thumbnail) }}" 
                                         alt="Thumbnail" 
                                         class="w-full h-auto rounded-2xl object-cover shadow-lg">
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-2 mb-8">
                                @if($post->category)
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                @foreach($post->tags as $tag)
                                    <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-800 dark:bg-purple-900/30 dark:text-purple-200">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="prose prose-gray dark:prose-invert max-w-none mb-8 text-gray-700 dark:text-gray-300 leading-relaxed">
                                {!! nl2br(e($post->content)) !!}
                            </div>

                            <!-- BAGIAN KOMENTAR -->
                            <div class="mt-12 pt-8 border-t border-slate-200 dark:border-gray-700">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Komentar ({{ $post->comments_count }})
                                </h3>

                                @if($post->comments->isNotEmpty())
                                    <div class="space-y-4 mb-8">
                                        @foreach($post->comments as $comment)
                                            <div class="bg-slate-50 dark:bg-gray-800 p-5 rounded-2xl relative group">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold">
                                                                {{ substr($comment->nama, 0, 1) }}
                                                            </div>
                                                            {{ htmlspecialchars($comment->nama) }}
                                                        </div>
                                                        <div class="mt-3 text-gray-700 dark:text-gray-300 leading-relaxed">
                                                            {!! nl2br(e($comment->isi_komentar)) !!}
                                                        </div>
                                                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $comment->created_at->format('d M Y H:i') }}
                                                        </div>
                                                    </div>

                                                    @auth
                                                        @if(auth()->user()->role === 'admin')
                                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        onclick="return confirm('Yakin hapus komentar ini?')"
                                                                        class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-800 rounded-2xl">
                                        Belum ada komentar. Jadilah yang pertama!
                                    </div>
                                @endif

                                <!-- FORM KOMENTAR -->
                                <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800 dark:to-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-gray-700">
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tinggalkan Komentar</h4>

                                    @if(session('success'))
                                        <div class="mb-4 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('comments.store', $post) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <input type="text" name="nama" value="{{ old('nama') }}" 
                                                   placeholder="Nama Anda" 
                                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20"
                                                   required>
                                            @error('nama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="mb-6">
                                            <textarea name="isi_komentar" rows="4" 
                                                      placeholder="Tulis komentar Anda..." 
                                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20"
                                                      required>{{ old('isi_komentar') }}</textarea>
                                            @error('isi_komentar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <button type="submit"
                                                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                            Kirim Komentar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR KANAN: BERITA TERKAIT -->
                <div class="lg:w-1/3">
                    @if($relatedPosts->isNotEmpty())
                        <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-3xl shadow-sm p-6 sticky top-24">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Berita Terkait
                            </h3>
                            <div class="space-y-4">
                                @foreach($relatedPosts as $related)
                                    <a href="{{ route('posts.show', $related) }}" class="block group">
                                        <div class="flex gap-4 p-3 rounded-2xl transition hover:bg-slate-50 dark:hover:bg-gray-800">
                                            @if($related->thumbnail)
                                                <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden shadow">
                                                    <img src="{{ asset('storage/'.$related->thumbnail) }}" 
                                                         alt="{{ $related->title }}"
                                                         class="w-full h-full object-cover transition group-hover:scale-110">
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2 text-sm leading-tight">
                                                    {{ $related->title }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
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