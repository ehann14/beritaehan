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
                                <div>{{ Auth::user()->name }}</div>
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
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
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

                {{-- DINAMIS: Ambil semua kategori dari database --}}
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
            <!-- Search di mobile -->
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

            <!-- Kategori Dinamis di Mobile -->
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
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>

                <div class="mt-3 space-y-1">
                    @if(auth()->user()->role === 'admin')
                        <x-responsive-nav-link :href="route('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
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