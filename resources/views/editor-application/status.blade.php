<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Status Pendaftaran Editor') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pantau status pendaftaran Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800 dark:border-blue-700 dark:bg-blue-900/30 dark:text-blue-200">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="p-8">
                    @if($application)
                        <!-- Status Badge -->
                        <div class="mb-6">
                            @if($application->status === 'pending')
                                <div class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Menunggu Review
                                </div>
                            @elseif($application->status === 'approved')
                                <div class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Disetujui - Anda Sekarang Editor!
                                </div>
                            @else
                                <div class="inline-flex items-center rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Ditolak
                                </div>
                            @endif
                        </div>

                        <!-- Detail Pendaftaran -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Lengkap</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $application->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nomor Telepon</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $application->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Alamat</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $application->address }}</p>
                            </div>
                            @if($application->reason)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Alasan</p>
                                    <p class="text-base text-gray-900 dark:text-white">{{ $application->reason }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tanggal Pendaftaran</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $application->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Alasan Penolakan -->
                        @if($application->status === 'rejected' && $application->rejection_reason)
                            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-700 dark:bg-red-900/20">
                                <p class="text-sm font-semibold text-red-800 dark:text-red-200 mb-2">Alasan Penolakan:</p>
                                <p class="text-sm text-red-700 dark:text-red-300">{{ $application->rejection_reason }}</p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-gray-700">
                            @if($application->status === 'approved')
                                <a href="{{ route('editor.dashboard') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                    Masuk ke Dashboard Editor
                                </a>
                            @elseif($application->status === 'rejected')
                                <a href="{{ route('editor.application.create') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Daftar Ulang
                                </a>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Silakan tunggu admin untuk mereview pendaftaran Anda.
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Belum Ada Pendaftaran</p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Anda belum mendaftar sebagai editor.</p>
                            <a href="{{ route('editor.application.create') }}"
                               class="mt-6 inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                Daftar Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>