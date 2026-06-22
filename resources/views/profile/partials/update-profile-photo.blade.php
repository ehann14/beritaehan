<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Foto Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Pilih foto profil dari koleksi yang tersedia.') }}
        </p>
    </header>

    @if (session('success'))
        <div class="mt-4 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6" x-data="{ showEdit: false }">
        {{-- Current Profile Photo Preview --}}
        <div class="flex items-center gap-6 mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl">
            <div class="relative">
                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-500 shadow">
                    <img src="{{ $user->profile_photo ? asset('images/profile-photos/' . $user->profile_photo) : asset('images/profile-photos/1.jpg') }}" 
                         alt="Profile Photo" 
                         class="w-full h-full object-cover"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3B82F6&color=fff&size=128'">
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($user->role) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="flex gap-2">
                <button @click="showEdit = !showEdit" 
                        type="button"
                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="showEdit ? 'Batal' : 'Edit'"></span>
                </button>
                @if($user->profile_photo)
                    <form action="{{ route('profile.photo.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Photo Selection Grid - Hanya muncul saat tombol Edit diklik --}}
        <div x-show="showEdit" x-collapse class="mt-6">
            <form action="{{ route('profile.photo.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Pilih Avatar:</h3>
                
                <div class="flex flex-wrap gap-3 mb-6">
                    @php
                        $photos = [
                            '1.jpg',
                            '2.jpg',
                            '3.jpg',
                            '4.jpg',
                        ];
                    @endphp

                    @foreach($photos as $photo)
                        <label class="relative cursor-pointer group">
                            <input type="radio" 
                                   name="profile_photo" 
                                   value="{{ $photo }}" 
                                   class="peer sr-only"
                                   {{ $user->profile_photo === $photo ? 'checked' : '' }}>
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg overflow-hidden border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500/30 transition-all hover:scale-110 bg-gray-100 dark:bg-gray-800">
                                <img src="{{ asset('images/profile-photos/' . $photo) }}" 
                                     alt="Avatar {{ $loop->iteration }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="absolute top-0 right-0 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <svg class="w-4 h-4 text-blue-600 bg-white rounded-full shadow" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                    <button type="button" 
                            @click="showEdit = false"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>