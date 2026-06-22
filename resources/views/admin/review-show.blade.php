<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Detail Berita untuk Review') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Baca berita sebelum mengambil keputusan.</p>
            </div>
            <a href="{{ route('admin.review.index') }}"
               class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                <span class="mr-2">←</span> Kembali ke Review
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <!-- Header Info -->
                <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="flex items-center gap-3">
                            @if($post->review_status === 'pending')
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">⏳ Menunggu Review</span>
                            @elseif($post->review_status === 'approved')
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200">✅ Disetujui</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200">❌ Ditolak</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Disubmit: {{ $post->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Thumbnail -->
                @if($post->thumbnail)
                    <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-2xl shadow" />
                    </div>
                @endif

                <!-- Konten -->
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6 pb-6 border-b border-slate-200 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Penulis: <strong class="text-gray-900 dark:text-white">{{ $post->author ?? '—' }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Dikirim oleh: <strong class="text-gray-900 dark:text-white">{{ $post->user->name ?? '—' }}</strong></span>
                        </div>
                        @if($post->category)
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">{{ $post->category->name }}</span>
                            </div>
                        @endif
                    </div>

                    @if($post->tags->isNotEmpty())
                        <div class="mb-6">
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">
                        {{ $post->content }}
                    </div>
                </div>

                <!-- Info Penolakan (jika ada) -->
                @if($post->review_status === 'rejected' && $post->rejection_reason)
                    <div class="p-6 bg-red-50 dark:bg-red-900/20 border-t border-red-200 dark:border-red-800">
                        <h4 class="font-semibold text-red-800 dark:text-red-200 mb-2">❌ Alasan Penolakan Sebelumnya:</h4>
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $post->rejection_reason }}</p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-2">
                            Ditolak oleh {{ $post->reviewer->name ?? '—' }} pada {{ $post->reviewed_at?->format('d M Y H:i') }}
                        </p>
                    </div>
                @endif

                <!-- Action Buttons -->
                @if($post->review_status === 'pending')
                    <div class="p-6 border-t border-slate-200 dark:border-gray-800 flex flex-wrap gap-3 justify-end">
                        <form action="{{ route('admin.review.approve', $post) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Yakin menyetujui berita ini? Berita akan langsung dipublish.')"
                                    class="inline-flex items-center rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Setujui & Publish
                            </button>
                        </form>
                        <button onclick="openRejectModal({{ $post->id }}, '{{ addslashes($post->title) }}')"
                                class="inline-flex items-center rounded-xl bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak Berita
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-lg rounded-3xl bg-white p-8 shadow-2xl dark:bg-gray-900">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">❌ Tolak Berita</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Berita: <strong id="rejectPostTitle"></strong></p>
            
            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="rejection_reason" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="rejection_reason" 
                              id="rejection_reason" 
                              rows="4" 
                              required
                              placeholder="Jelaskan alasan penolakan berita ini..."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter</p>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 text-sm font-semibold text-white hover:bg-red-700 transition">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openRejectModal(postId, postTitle) {
        document.getElementById('rejectPostTitle').textContent = postTitle;
        document.getElementById('rejectForm').action = '/admin/review/' + postId + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
        document.getElementById('rejection_reason').value = '';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
    </script>
</x-app-layout>