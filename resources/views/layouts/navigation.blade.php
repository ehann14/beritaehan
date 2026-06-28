<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 🔹 BARIS 1: Logo (kiri) + Search (tengah) + Akun (kanan) -->
        <div class="flex items-center justify-between h-16">
            <!-- Logo di kiri -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-12 w-auto" />
                </a>
            </div>

            <!-- Search Bar di tengah -->
            <div class="hidden sm:flex items-center">
                <form method="GET" action="{{ route('berita.index') }}" class="flex">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari berita..."
                           class="px-4 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 w-full sm:w-[32rem]">
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Akun/Login di kanan -->
            <div class="flex items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-blue-500 shadow-sm">
                                        <img src="{{ Auth::user()->profile_photo ? asset('images/profile-photos/' . Auth::user()->profile_photo) : asset('images/profile-photos/1.jpg') }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff&size=128'">
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(auth()->user()->role === 'admin')
                                <x-dropdown-link :href="route('dashboard')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        {{ __('Dashboard Admin') }}
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.review.index')">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            {{ __('Review Berita') }}
                                        </div>
                                        @php $pendingPosts = \App\Models\Post::pending()->count(); @endphp
                                        @if($pendingPosts > 0)
                                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                                {{ $pendingPosts }}
                                            </span>
                                        @endif
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.editor-applications.index')">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            {{ __('Pendaftaran Editor') }}
                                        </div>
                                        @php $pendingApps = \App\Models\EditorApplication::pending()->count(); @endphp
                                        @if($pendingApps > 0)
                                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                                {{ $pendingApps }}
                                            </span>
                                        @endif
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('posts.index')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('Kelola Semua Berita') }}
                                    </div>
                                </x-dropdown-link>
                            @elseif(auth()->user()->role === 'editor')
                                <x-dropdown-link :href="route('editor.dashboard')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        {{ __('Dashboard Editor') }}
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('editor.posts.index')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('Berita Saya') }}
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('editor.posts.create')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ __('Buat Berita Baru') }}
                                    </div>
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('editor.application.create')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        {{ __('Daftar Jadi Editor') }}
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('editor.application.status')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                        {{ __('Status Pendaftaran') }}
                                    </div>
                                </x-dropdown-link>
                            @endif
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            
                            <!-- TAMBAHAN: Berita Tersimpan (Bookmark) -->
                            <x-dropdown-link :href="route('bookmarks.index')">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                        {{ __('Berita Tersimpan') }}
                                    </div>
                                    @php $bookmarkCount = \App\Models\Bookmark::where('user_id', auth()->id())->count(); @endphp
                                    @if($bookmarkCount > 0)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-yellow-500 rounded-full">
                                            {{ $bookmarkCount }}/7
                                        </span>
                                    @endif
                                </div>
                            </x-dropdown-link>

                            <!-- Riwayat Membaca -->
                            <x-dropdown-link :href="route('reading-history.index')">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    {{ __('Riwayat Membaca') }}
                                </div>
                            </x-dropdown-link>

                            <!-- TAMBAHAN: Riwayat Warning (BARU) -->
                            <x-dropdown-link :href="route('user.warnings')">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        {{ __('Riwayat Warning') }}
                                    </div>
                                    @php
                                        $activeWarnings = auth()->user()->warnings()
                                            ->where(function ($query) {
                                                $query->whereNull('expires_at')
                                                      ->orWhere('expires_at', '>', now());
                                            })
                                            ->count();
                                    @endphp
                                    @if($activeWarnings > 0)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full animate-pulse">
                                            {{ $activeWarnings }}
                                        </span>
                                    @endif
                                </div>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('profile.edit')">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Profile') }}
                                </div>
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Log Out') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Log in') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger (untuk mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- 🔹 BARIS 2: Kategori (DINAMIS) -->
        <div class="border-t border-gray-200 dark:border-gray-700 py-2">
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    {{ __('Home') }}
                </a>

                @php
                    $categories = \App\Models\Category::orderBy('name')->get();
                @endphp
                @foreach($categories as $category)
                    <a href="{{ route('berita.index', ['category' => $category->name]) }}"
                       class="{{ request('category') === $category->name ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- MOBILE: Menu publik -->
        <div class="pt-2 pb-3 space-y-1 px-4">
            <div class="mb-4">
                <form method="GET" action="{{ route('berita.index') }}" class="flex">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari berita..."
                           class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 w-full">
                    <button type="submit"
                            class="ms-2 px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        Cari
                    </button>
                </form>
            </div>

            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @php
                $categories = \App\Models\Category::orderBy('name')->get();
            @endphp
            @foreach($categories as $category)
                <x-responsive-nav-link 
                    :href="route('berita.index', ['category' => $category->name])"
                    :active="request('category') === $category->name">
                    {{ $category->name }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <!-- MOBILE: Menu user -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-blue-500 shadow-lg">
                        <img src="{{ Auth::user()->profile_photo ? asset('images/profile-photos/' . Auth::user()->profile_photo) : asset('images/profile-photos/1.jpg') }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff&size=128'">
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        <div class="mt-1">
                            @if(auth()->user()->role === 'admin')
                                <span class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900/30 dark:text-purple-200">
                                    Admin
                                </span>
                            @elseif(auth()->user()->role === 'editor')
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                    Editor
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-900/30 dark:text-gray-200">
                                    User
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(auth()->user()->role === 'admin')
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('Dashboard Admin') }}
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.review.index')" :active="request()->routeIs('admin.review.*')">
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    {{ __('Review Berita') }}
                                </div>
                                @php $pendingPosts = \App\Models\Post::pending()->count(); @endphp
                                @if($pendingPosts > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                        {{ $pendingPosts }}
                                    </span>
                                @endif
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.editor-applications.index')" :active="request()->routeIs('admin.editor-applications.*')">
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ __('Pendaftaran Editor') }}
                                </div>
                                @php $pendingApps = \App\Models\EditorApplication::pending()->count(); @endphp
                                @if($pendingApps > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                        {{ $pendingApps }}
                                    </span>
                                @endif
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('Kelola Semua Berita') }}
                            </div>
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->role === 'editor')
                        <x-responsive-nav-link :href="route('editor.dashboard')" :active="request()->routeIs('editor.dashboard')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('Dashboard Editor') }}
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('editor.posts.index')" :active="request()->routeIs('editor.posts.index')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('Berita Saya') }}
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('editor.posts.create')" :active="request()->routeIs('editor.posts.create')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Buat Berita Baru') }}
                            </div>
                        </x-responsive-nav-link>
                    @else
                        <x-responsive-nav-link :href="route('editor.application.create')" :active="request()->routeIs('editor.application.create')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                {{ __('Daftar Jadi Editor') }}
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('editor.application.status')" :active="request()->routeIs('editor.application.status')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                {{ __('Status Pendaftaran') }}
                            </div>
                        </x-responsive-nav-link>
                    @endif
                    
                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                    
                    <!-- TAMBAHAN: Berita Tersimpan (Bookmark) Mobile -->
                    <x-responsive-nav-link :href="route('bookmarks.index')" :active="request()->routeIs('bookmarks.index')">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                {{ __('Berita Tersimpan') }}
                            </div>
                            @php $bookmarkCount = \App\Models\Bookmark::where('user_id', auth()->id())->count(); @endphp
                            @if($bookmarkCount > 0)
                                <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-yellow-500 rounded-full">
                                    {{ $bookmarkCount }}/7
                                </span>
                            @endif
                        </div>
                    </x-responsive-nav-link>

                    <!-- Riwayat Membaca Mobile -->
                    <x-responsive-nav-link :href="route('reading-history.index')" :active="request()->routeIs('reading-history.index')">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            {{ __('Riwayat Membaca') }}
                        </div>
                    </x-responsive-nav-link>

                    <!-- TAMBAHAN: Riwayat Warning Mobile (BARU) -->
                    <x-responsive-nav-link :href="route('user.warnings')" :active="request()->routeIs('user.warnings')">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                {{ __('Riwayat Warning') }}
                            </div>
                            @php
                                $activeWarnings = auth()->user()->warnings()
                                    ->where(function ($query) {
                                        $query->whereNull('expires_at')
                                              ->orWhere('expires_at', '>', now());
                                    })
                                    ->count();
                            @endphp
                            @if($activeWarnings > 0)
                                <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full animate-pulse">
                                    {{ $activeWarnings }}
                                </span>
                            @endif
                        </div>
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </div>
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </div>
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 space-y-2 px-4 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('login') }}" class="block font-medium text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-400">
                    {{ __('Log in') }}
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block font-medium text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-400">
                        {{ __('Register') }}
                    </a>
                @endif
            </div>
        @endauth
    </div>
</nav>