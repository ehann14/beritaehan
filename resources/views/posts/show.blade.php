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

    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-0">
            <!-- KOLOM UTAMA: ISI BERITA -->
            <div class="lg:w-3/4 bg-white dark:bg-gray-900 border-r border-slate-200 dark:border-gray-800">
                <div class="p-8 lg:p-12">
                    
                    <!-- Notifikasi Success / Error Bookmark -->
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 rounded-xl border border-red-200 bg-red-50 text-sm text-red-800 dark:border-red-700 dark:bg-red-900/30 dark:text-red-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Judul dengan Tombol Bookmark -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight">
                            {{ $post->title }}
                        </h1>
                        
                        @auth
                        <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ $isBookmarked ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                                @if($isBookmarked)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                    Tersimpan
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    Simpan
                                @endif
                            </button>
                        </form>
                        @endauth
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-8 pb-6 border-b border-slate-200 dark:border-gray-700">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">{{ $post->created_at->format('d M Y') }}</span>
                        </span>
                        <span class="text-slate-300 dark:text-gray-600">•</span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-medium">{{ $post->author ?? 'Tidak diketahui' }}</span>
                        </span>
                    </div>

                    @if($post->thumbnail)
                        <div class="mb-10 flex justify-center">
                            <div class="max-w-2xl w-full">
                                <img src="{{ asset('storage/'.$post->thumbnail) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-auto rounded-2xl shadow-2xl">
                            </div>
                        </div>
                    @endif

                    <div class="mb-12 p-6 bg-slate-50 dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-3">
                            @if($post->category)
                                <span class="inline-flex items-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-lg">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            @foreach($post->tags as $tag)
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 px-5 py-2 text-sm font-semibold text-purple-800 dark:text-purple-200">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="prose prose-lg prose-gray dark:prose-invert max-w-none mb-20 text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- BAGIAN KOMENTAR -->
                    <div class="mt-24 pt-12 border-t-4 border-slate-200 dark:border-gray-700">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Komentar ({{ $post->comments_count }})
                        </h3>

                        @if($post->comments->isNotEmpty())
                            <div class="space-y-5 mb-10">
                                @foreach($post->comments as $comment)
                                    <div class="bg-slate-50 dark:bg-gray-800 p-6 rounded-2xl relative group border border-slate-200 dark:border-gray-700">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="font-semibold text-gray-900 dark:text-white flex items-center gap-3 mb-3">
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-base font-bold shadow-lg">
                                                        {{ substr($comment->nama, 0, 1) }}
                                                    </div>
                                                    <span class="text-lg">{{ htmlspecialchars($comment->nama) }}</span>
                                                </div>
                                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-base ml-13">
                                                    {!! nl2br(e($comment->isi_komentar)) !!}
                                                </div>
                                                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400 ml-13 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
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
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-lg font-medium">Belum ada komentar</p>
                                <p class="text-sm mt-2">Jadilah yang pertama untuk berkomentar!</p>
                            </div>
                        @endif

                        <!-- FORM KOMENTAR -->
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800 dark:to-slate-800 p-8 rounded-2xl border-2 border-slate-200 dark:border-gray-700">
                            <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Tinggalkan Komentar
                            </h4>

                            @auth
                                <form action="{{ route('comments.store', $post) }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-5">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                        <input type="text" 
                                               name="nama" 
                                               value="{{ Auth::user()->name }}" 
                                               readonly
                                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-100 text-slate-900 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nama otomatis terisi dari akun Anda</p>
                                    </div>

                                    <div class="mb-6">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Komentar</label>
                                        <textarea name="isi_komentar" rows="5" 
                                                  placeholder="Tulis komentar Anda di sini..." 
                                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20"
                                                  required>{{ old('isi_komentar') }}</textarea>
                                        @error('isi_komentar')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-3 text-sm font-bold text-white shadow-lg transition hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Kirim Komentar
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Silakan login untuk berkomentar</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Anda harus masuk ke akun terlebih dahulu untuk meninggalkan komentar</p>
                                    <div class="flex items-center justify-center gap-4">
                                        <a href="{{ route('login') }}" 
                                           class="inline-flex items-center px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                            Login
                                        </a>
                                        <a href="{{ route('register') }}" 
                                           class="inline-flex items-center px-6 py-3 rounded-xl border-2 border-blue-600 text-blue-600 font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                                            Daftar Akun
                                        </a>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR KANAN: BERITA TERKAIT (DENGAN UKURAN FIXED) -->
            <div class="lg:w-1/4 bg-slate-50 dark:bg-gray-950">
                <div class="p-6 lg:p-8 sticky top-0">
                    @if($relatedPosts->isNotEmpty())
                        <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-4 border-b-2 border-slate-200 dark:border-gray-700">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Berita Terkait
                            </h3>
                            <div class="space-y-4">
                                @foreach($relatedPosts as $related)
                                    <a href="{{ route('posts.show', $related) }}" class="block group">
                                        <div class="flex gap-3 p-3 rounded-xl transition hover:bg-slate-50 dark:hover:bg-gray-800 border border-transparent hover:border-slate-200 dark:hover:border-gray-700">
                                            <!-- Thumbnail dengan ukuran EXACT FIXED 80x80px -->
                                            <div class="flex-shrink-0" style="width: 80px; height: 80px; min-width: 80px; min-height: 80px; max-width: 80px; max-height: 80px;">
                                                <div class="w-full h-full rounded-xl overflow-hidden shadow-md bg-gray-200 dark:bg-gray-700">
                                                    @if($related->thumbnail)
                                                        <img src="{{ asset('storage/'.$related->thumbnail) }}" 
                                                             alt="{{ $related->title }}"
                                                             style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Content dengan tinggi EXACT FIXED 80px -->
                                            <div class="flex-1 min-w-0" style="height: 80px;">
                                                <div class="h-full flex flex-col justify-between">
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 text-sm leading-snug mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                            {{ Str::limit($related->title, 50) }}
                                                        </h4>
                                                    </div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $related->created_at->format('d M Y') }}
                                                    </p>
                                                </div>
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