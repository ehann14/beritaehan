<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Riwayat Peringatan Saya') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lihat semua peringatan yang pernah Anda terima</p>
            </div>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 rounded-xl bg-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-gray-700 dark:text-slate-200 dark:hover:bg-gray-600 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-3xl border border-slate-200 dark:border-gray-800">
                <div class="p-6">
                    @if($warnings->count() > 0)
                        <div class="space-y-4">
                            @foreach($warnings as $warning)
                                <div class="rounded-2xl border-2 p-5 transition-all duration-300 hover:shadow-lg
                                    {{ $warning->type === 'ban' ? 'border-red-200 bg-red-50 dark:border-red-500/30 dark:bg-red-900/20' : '' }}
                                    {{ $warning->type === 'suspend' ? 'border-orange-200 bg-orange-50 dark:border-orange-500/30 dark:bg-orange-900/20' : '' }}
                                    {{ $warning->type === 'warning' ? 'border-yellow-200 bg-yellow-50 dark:border-yellow-500/30 dark:bg-yellow-900/20' : '' }}">
                                    
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold text-white
                                                    {{ $warning->type === 'ban' ? 'bg-red-600' : '' }}
                                                    {{ $warning->type === 'suspend' ? 'bg-orange-600' : '' }}
                                                    {{ $warning->type === 'warning' ? 'bg-yellow-600' : '' }}">
                                                    {{ strtoupper($warning->type) }}
                                                </span>
                                                @if($warning->isActive())
                                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 dark:text-green-400">
                                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500">
                                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                                        Expired
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <p class="text-base font-bold text-gray-900 dark:text-white mb-2">{{ $warning->reason }}</p>
                                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">{{ $warning->message }}</p>
                                            
                                            <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                                                <p><strong class="text-gray-800 dark:text-gray-300">Diberi oleh:</strong> {{ $warning->admin->name }}</p>
                                                <p><strong class="text-gray-800 dark:text-gray-300">Tanggal:</strong> {{ $warning->created_at->format('d M Y H:i') }}</p>
                                                @if($warning->expires_at)
                                                    <p><strong class="text-gray-800 dark:text-gray-300">Berlaku hingga:</strong> {{ $warning->expires_at->format('d M Y H:i') }}</p>
                                                @else
                                                    <p><strong class="text-gray-800 dark:text-gray-300">Status:</strong> Permanen</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8">
                            {{ $warnings->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tidak Ada Peringatan</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Akun Anda bersih dari peringatan. Terus jaga perilaku yang baik!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>