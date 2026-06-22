<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Review Berita Editor') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Periksa, setujui, atau tolak berita dari editor.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistik Cards -->
            <div class="grid gap-6 sm:grid-cols-3 mb-8">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-yellow-500 to-orange-400 shadow-lg shadow-yellow-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Menunggu Review</p>
                                <p class="mt-4 text-4xl font-semibold">{{ $totalPending }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-500 shadow-lg shadow-emerald-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Disetujui</p>
                                <p class="mt-4 text-4xl font-semibold">{{ $totalApproved }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-600 to-red-500 shadow-lg shadow-red-200/20">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Ditolak</p>
                                <p class="mt-4 text-4xl font-semibold">{{ $totalRejected }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/15 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('admin.review.index', ['filter' => 'pending']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'pending' ? 'bg-yellow-500 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    ⏳ Menunggu ({{ $totalPending }})
                </a>
                <a href="{{ route('admin.review.index', ['filter' => 'approved']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'approved' ? 'bg-emerald-500 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    ✅ Disetujui ({{ $totalApproved }})
                </a>
                <a href="{{ route('admin.review.index', ['filter' => 'rejected']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'rejected' ? 'bg-red-500 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    ❌ Ditolak ({{ $totalRejected }})
                </a>
                <a href="{{ route('admin.review.index', ['filter' => 'all']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'all' ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    📋 Semua
                </a>
            </div>

            <!-- Tabel Berita -->
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-gray-800">
                            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-600 dark:bg-gray-900 dark:text-slate-400">
                                <tr>
                                    <th class="px-4 py-4">Thumbnail</th>
                                    <th class="px-4 py-4">Judul</th>
                                    <th class="px-4 py-4">Editor</th>
                                    <th class="px-4 py-4">Kategori</th>
                                    <th class="px-4 py-4">Tanggal Submit</th>
                                    <th class="px-4 py-4">Status</th>
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
                                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-sm text-slate-500 dark:bg-gray-800 dark:text-slate-400">—</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle">
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ Str::limit($post->title, 40) }}</div>
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $post->user->name ?? '—' }}</td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            @if($post->category)
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">{{ $post->category->name }}</span>
                                            @else
                                                <span class="text-slate-500">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm text-slate-700 dark:text-slate-300">{{ $post->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            @if($post->review_status === 'pending')
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">⏳ Pending</span>
                                            @elseif($post->review_status === 'approved')
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200">✅ Disetujui</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200">❌ Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-sm">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('admin.review.show', $post) }}" class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                                                    👁 Baca
                                                </a>
                                                @if($post->review_status === 'pending')
                                                    <form action="{{ route('admin.review.approve', $post) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('Yakin menyetujui berita ini? Berita akan langsung dipublish.')"
                                                                class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200 dark:hover:bg-emerald-500/20">
                                                            ✅ Setujui
                                                        </button>
                                                    </form>
                                                    <button onclick="openRejectModal({{ $post->id }}, '{{ addslashes($post->title) }}')"
                                                            class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 dark:hover:bg-red-500/20">
                                                        ❌ Tolak
                                                    </button>
                                                @else
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        oleh {{ $post->reviewer->name ?? '—' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-10 text-center">
                                            <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada berita dengan status ini.</p>
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

    <!-- Modal Tolak Berita -->
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
                              placeholder="Jelaskan alasan penolakan berita ini (misal: konten hoaks, informasi tidak akurat, dll)..."
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