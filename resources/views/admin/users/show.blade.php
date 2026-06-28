<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    Detail User: {{ $user->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Informasi lengkap dan riwayat aktivitas user.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-gray-700 dark:text-slate-200 dark:hover:bg-gray-600">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- 🔹 INFORMASI USER --}}
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi User</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="flex-shrink-0">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full object-cover" />
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-500 text-white text-3xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Nama</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Email</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Role</p>
                                <p class="mt-1">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300' : '' }}
                                        {{ $user->role === 'editor' ? 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300' : '' }}
                                        {{ $user->role === 'user' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' : '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Terdaftar</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $user->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Total Posts</p>
                                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts_count }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Total Komentar</p>
                                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $user->comments_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔹 AKSI ADMIN --}}
            @if($user->role !== 'admin' && $user->id !== auth()->id())
                <div class="grid gap-6 lg:grid-cols-2">
                    {{-- Beri Peringatan --}}
                    <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden">
                        <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Beri Peringatan</h3>
                        </div>
                        <form action="{{ route('admin.users.warn', $user) }}" method="POST" class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis Peringatan</label>
                                <select name="type" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                                    <option value="warning">Warning (Peringatan)</option>
                                    <option value="suspend">Suspend (Suspensi)</option>
                                    <option value="ban">Ban (Banned)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alasan</label>
                                <input type="text" name="reason" required placeholder="Contoh: Pelanggaran aturan komunitas"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pesan Peringatan</label>
                                <textarea name="message" rows="3" required placeholder="Jelaskan pelanggaran dan konsekuensi..."
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Berlaku Hingga (Opsional)</label>
                                <input type="datetime-local" name="expires_at"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika peringatan permanen</p>
                            </div>
                            <button type="submit" class="w-full rounded-xl bg-orange-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-orange-700">
                                Beri Peringatan
                            </button>
                        </form>
                    </div>

                    {{-- Ubah Role --}}
                    <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden">
                        <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ubah Role</h3>
                        </div>
                        <form action="{{ route('admin.users.change-role', $user) }}" method="POST" class="p-6 space-y-4">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Role Baru</label>
                                <select name="role" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <button type="submit" onclick="return confirm('Yakin ingin mengubah role {{ $user->name }}?')" class="w-full rounded-xl bg-purple-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-purple-700">
                                Ubah Role
                            </button>
                        </form>

                        <div class="p-6 border-t border-slate-200 dark:border-gray-800">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('PERINGATAN: Akun {{ $user->name }} akan dihapus PERMANEN beserta semua data!\n\nYakin ingin melanjutkan?')" class="w-full rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-700">
                                    Hapus Akun Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            {{-- 🔹 RIWAYAT WARNING --}}
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Peringatan ({{ $warnings->total() }})</h3>
                </div>
                <div class="p-6">
                    @if($warnings->count() > 0)
                        <div class="space-y-4">
                            @foreach($warnings as $warning)
                                <div class="rounded-xl border-2 p-4
                                    {{ $warning->type === 'ban' ? 'border-red-200 bg-red-50 dark:border-red-500/30 dark:bg-red-500/10' : '' }}
                                    {{ $warning->type === 'suspend' ? 'border-orange-200 bg-orange-50 dark:border-orange-500/30 dark:bg-orange-500/10' : '' }}
                                    {{ $warning->type === 'warning' ? 'border-yellow-200 bg-yellow-50 dark:border-yellow-500/30 dark:bg-yellow-500/10' : '' }}">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                                    {{ $warning->type === 'ban' ? 'bg-red-600 text-white' : '' }}
                                                    {{ $warning->type === 'suspend' ? 'bg-orange-600 text-white' : '' }}
                                                    {{ $warning->type === 'warning' ? 'bg-yellow-600 text-white' : '' }}">
                                                    {{ strtoupper($warning->type) }}
                                                </span>
                                                @if($warning->isActive())
                                                    <span class="text-xs font-semibold text-green-600 dark:text-green-400">● Aktif</span>
                                                @else
                                                    <span class="text-xs font-semibold text-gray-500">● Expired</span>
                                                @endif
                                            </div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ $warning->reason }}</p>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $warning->message }}</p>
                                            <div class="mt-2 flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                <span>Diberi oleh: {{ $warning->admin->name }}</span>
                                                <span>Tanggal: {{ $warning->created_at->format('d M Y H:i') }}</span>
                                                @if($warning->expires_at)
                                                    <span>Berlaku hingga: {{ $warning->expires_at->format('d M Y H:i') }}</span>
                                                @else
                                                    <span>Permanen</span>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.warnings.destroy', $warning) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus peringatan ini?')" class="rounded-lg border border-red-200 bg-white px-3 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-50 dark:border-red-500/30 dark:bg-gray-800 dark:text-red-200 dark:hover:bg-red-500/20">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $warnings->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Belum ada riwayat peringatan</p>
                    @endif
                </div>
            </div>

            {{-- 🔹 POSTS TERBARU --}}
            @if($recentPosts->count() > 0)
                <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-3xl overflow-hidden">
                    <div class="p-6 border-b border-slate-200 dark:border-gray-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Posts Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($recentPosts as $post)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $post->title }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->category?->name ?? 'Tanpa kategori' }} • {{ $post->created_at->format('d M Y') }}</p>
                                    </div>
                                    <a href="{{ route('posts.show', $post) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>