<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Review Pendaftaran Editor') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Setujui atau tolak pendaftaran editor baru.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid gap-6 sm:grid-cols-3 mb-8">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-yellow-500 to-orange-400 shadow-lg">
                    <div class="p-6 text-white">
                        <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Menunggu Review</p>
                        <p class="mt-4 text-4xl font-semibold">{{ $totalPending }}</p>
                    </div>
                </div>
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-500 shadow-lg">
                    <div class="p-6 text-white">
                        <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Disetujui</p>
                        <p class="mt-4 text-4xl font-semibold">{{ $totalApproved }}</p>
                    </div>
                </div>
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-600 to-red-500 shadow-lg">
                    <div class="p-6 text-white">
                        <p class="text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Ditolak</p>
                        <p class="mt-4 text-4xl font-semibold">{{ $totalRejected }}</p>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('admin.editor-applications.index', ['filter' => 'pending']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300' }}">
                    ⏳ Menunggu ({{ $totalPending }})
                </a>
                <a href="{{ route('admin.editor-applications.index', ['filter' => 'approved']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'approved' ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300' }}">
                    ✅ Disetujui ({{ $totalApproved }})
                </a>
                <a href="{{ route('admin.editor-applications.index', ['filter' => 'rejected']) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filter === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300' }}">
                    ❌ Ditolak ({{ $totalRejected }})
                </a>
            </div>

            <!-- Tabel -->
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-gray-800">
                        <thead class="bg-slate-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">Nama</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">Telepon</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">Alamat</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">Tanggal</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">Status</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-gray-800 bg-white dark:bg-gray-950">
                            @forelse($applications as $app)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/80">
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $app->full_name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $app->user->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $app->phone }}</td>
                                    <td class="px-4 py-4 text-sm text-slate-700 dark:text-slate-300">{{ Str::limit($app->address, 50) }}</td>
                                    <td class="px-4 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $app->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-4">
                                        @if($app->status === 'pending')
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">⏳ Pending</span>
                                        @elseif($app->status === 'approved')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200">✅ Approved</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200">❌ Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($app->status === 'pending')
                                            <div class="flex gap-2">
                                                <form action="{{ route('admin.editor-applications.approve', $app) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Setujui pendaftaran ini?')"
                                                            class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
                                                        ✅ Setujui
                                                    </button>
                                                </form>
                                                <button onclick="openRejectModal({{ $app->id }}, '{{ addslashes($app->full_name) }}')"
                                                        class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200">
                                                    ❌ Tolak
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                                oleh {{ $app->reviewer->name ?? '—' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                        Tidak ada pendaftaran dengan status ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-lg rounded-3xl bg-white p-8 shadow-2xl dark:bg-gray-900">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tolak Pendaftaran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nama: <strong id="rejectName"></strong></p>
            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="rejection_reason" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 dark:border-gray-700 dark:text-gray-300">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 text-sm font-semibold text-white hover:bg-red-700">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openRejectModal(id, name) {
        document.getElementById('rejectName').textContent = name;
        document.getElementById('rejectForm').action = '/admin/editor-applications/' + id + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
    </script>
</x-app-layout>