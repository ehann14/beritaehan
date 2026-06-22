<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Pendaftaran Editor') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Isi data diri Anda untuk mendaftar sebagai editor.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="p-8">
                    @if(session('error'))
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-700 dark:bg-red-900/30 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Info Box -->
                    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-700 dark:bg-blue-900/20">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800 dark:text-blue-200">📋 Informasi Penting</p>
                                <ul class="text-xs text-blue-600 dark:text-blue-300 mt-2 space-y-1">
                                    <li>• Pendaftaran akan direview oleh admin</li>
                                    <li>• Pastikan data yang diisi benar dan lengkap</li>
                                    <li>• Anda akan mendapat notifikasi setelah pendaftaran disetujui/ditolak</li>
                                    <li>• Setelah disetujui, Anda bisa membuat dan mengelola berita</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('editor.application.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="full_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="full_name" 
                                   id="full_name" 
                                   required
                                   value="{{ old('full_name', auth()->user()->name) }}"
                                   placeholder="Masukkan nama lengkap Anda"
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20" />
                            @error('full_name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   required
                                   value="{{ old('phone') }}"
                                   placeholder="Contoh: 08123456789"
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20" />
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Alamat Rumah <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" 
                                      id="address" 
                                      rows="3" 
                                      required
                                      placeholder="Masukkan alamat lengkap rumah Anda"
                                      class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alasan (Opsional) -->
                        <div>
                            <label for="reason" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Alasan Ingin Menjadi Editor
                            </label>
                            <textarea name="reason" 
                                      id="reason" 
                                      rows="4" 
                                      placeholder="Ceritakan mengapa Anda ingin menjadi editor (opsional)"
                                      class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20">{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-gray-700">
                            <a href="{{ route('home') }}"
                               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>