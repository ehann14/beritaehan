<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name', 'EhanNews') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.25),_transparent_18%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.16),_transparent_20%),linear-gradient(180deg,_#020617_0%,_#0f172a_100%)]">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-white/10 text-2xl font-black text-sky-400 shadow-lg shadow-sky-500/10">EN</div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-sky-300/80">EhanNews</p>
                            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Berita terbaru, lebih cepat, lebih jelas.</h1>
                        </div>
                    </div>

                    <nav class="flex flex-wrap items-center gap-3 text-sm">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-full border border-slate-700 bg-slate-900/90 px-4 py-2 text-slate-100 transition hover:bg-slate-800">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full border border-slate-700 bg-white/5 px-4 py-2 text-slate-100 transition hover:bg-white/10">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-full border border-sky-500/30 bg-sky-500/10 px-4 py-2 text-sky-200 transition hover:bg-sky-500/20">Register</a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </header>

                <section class="mt-12 grid gap-10 lg:grid-cols-[1.35fr_0.85fr] lg:items-center">
                    <div class="space-y-8">
                        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
                            <p class="text-sm uppercase tracking-[0.3em] text-sky-300/80">Cari berita terbaru</p>
                            <h2 class="mt-4 text-4xl font-bold leading-tight text-white md:text-5xl">Jelajahi berita lokal dan global dalam satu halaman.</h2>
                            <p class="mt-4 max-w-2xl text-slate-300">Temukan artikel teknologi, olahraga, startup, dan opini dengan tampilan modern yang mudah dibaca.</p>

                            <form action="{{ route('berita.index') }}" method="GET" class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <label for="search" class="sr-only">Cari berita</label>
                                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full rounded-3xl border border-slate-700 bg-slate-950/80 px-5 py-4 text-sm text-slate-100 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-500/20" />
                                <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-sky-500 px-6 py-4 text-sm font-semibold text-white transition hover:bg-sky-400">Cari</button>
                            </form>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('berita.index', ['category' => 'Home']) }}" class="rounded-full bg-white/10 px-4 py-2 text-sm text-slate-100 transition hover:bg-white/15">Home</a>
                                <a href="{{ route('berita.index', ['category' => 'Gadget']) }}" class="rounded-full bg-white/10 px-4 py-2 text-sm text-slate-100 transition hover:bg-white/15">Gadget</a>
                                <a href="{{ route('berita.index', ['category' => 'Sport']) }}" class="rounded-full bg-white/10 px-4 py-2 text-sm text-slate-100 transition hover:bg-white/15">Sport</a>
                                <a href="{{ route('berita.index', ['category' => 'Startup']) }}" class="rounded-full bg-white/10 px-4 py-2 text-sm text-slate-100 transition hover:bg-white/15">Startup</a>
                                <a href="{{ route('berita.index', ['category' => 'Teknologi']) }}" class="rounded-full bg-white/10 px-4 py-2 text-sm text-slate-100 transition hover:bg-white/15">Teknologi</a>
                            </div>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 text-slate-100 shadow-xl shadow-slate-950/30">
                                <p class="text-sm uppercase tracking-[0.3em] text-sky-400/80">Fitur</p>
                                <h3 class="mt-3 text-2xl font-semibold">Akses berita cepat</h3>
                                <p class="mt-2 text-slate-400">Cari artikel, kategori, dan tag dengan mudah dalam satu antarmuka bersih dan minimalis.</p>
                            </div>
                            <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 text-slate-100 shadow-xl shadow-slate-950/30">
                                <p class="text-sm uppercase tracking-[0.3em] text-sky-400/80">Kontrol</p>
                                <h3 class="mt-3 text-2xl font-semibold">Navigasi intuitif</h3>
                                <p class="mt-2 text-slate-400">Tombol login, register, dan dashboard tersedia dengan jelas untuk pengguna baru dan admin.</p>
                            </div>
                        </div>
                    </div>

                    <aside class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
                        <div class="rounded-3xl bg-slate-950/90 p-6 text-slate-100 shadow-inner shadow-slate-950/30">
                            <p class="text-sm uppercase tracking-[0.3em] text-sky-300/80">Highlight</p>
                            <h3 class="mt-4 text-2xl font-semibold">Berita populer saat ini</h3>
                            <ul class="mt-6 space-y-4 text-slate-300">
                                <li class="rounded-3xl border border-slate-800 bg-slate-900/80 p-4">
                                    <p class="font-semibold text-slate-100">Telkom luncurkan fitur AI baru untuk pengguna</p>
                                    <span class="text-xs text-slate-500">3 jam lalu</span>
                                </li>
                                <li class="rounded-3xl border border-slate-800 bg-slate-900/80 p-4">
                                    <p class="font-semibold text-slate-100">Startup lokal raih pendanaan seri A</p>
                                    <span class="text-xs text-slate-500">1 hari lalu</span>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </section>
            </div>
        </div>
    </body>
</html>
