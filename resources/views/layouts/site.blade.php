<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Nusakode — Perusahaan Jasa Teknologi Informasi Indonesia')</title>
    <meta name="description" content="@yield('meta-description', 'PT Nusakode Teknologi: jasa pengembangan aplikasi web, sistem informasi, integrasi sistem, infrastruktur cloud, dan keamanan informasi untuk perusahaan di Indonesia.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-neutral-700">

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-3 focus:top-3 focus:z-[100] focus:bg-white focus:px-4 focus:py-2 focus:text-sm">Lewati ke konten</a>

{{-- ============ NAVIGASI KACA (global) ============ --}}
@php($isHome = request()->is('/'))
<header id="glass-header" @if ($isHome) data-transparent-top @endif class="fixed inset-x-0 top-0 z-50 transition duration-300 {{ $isHome ? '' : 'border-b border-white/10 bg-navy-950/80 shadow-sm backdrop-blur' }}">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ url('/') }}" class="text-xl font-extrabold tracking-[0.18em] text-white">NUSAKODE<span class="text-brand-400">.</span></a>
        <nav class="hidden items-center gap-9 text-[13px] font-semibold text-neutral-200 lg:flex" aria-label="Navigasi utama">
            <a href="{{ url('/') }}" class="relative pb-1.5 transition hover:text-white {{ $isHome ? 'text-white' : '' }}">Beranda @if ($isHome)<span class="absolute inset-x-0 -bottom-0.5 h-0.5 bg-brand-500" aria-hidden="true"></span>@endif</a>
            <a href="{{ url('/#layanan') }}" class="pb-1.5 transition hover:text-white">Layanan</a>
            <a href="{{ url('/#solusi') }}" class="pb-1.5 transition hover:text-white">Solusi</a>
            <a href="{{ url('/#portofolio') }}" class="pb-1.5 transition hover:text-white">Portofolio</a>
            <a href="{{ url('/#tentang') }}" class="pb-1.5 transition hover:text-white">Tentang</a>
            <a href="{{ route('kontak') }}" class="pb-1.5 transition hover:text-white {{ request()->routeIs('kontak*') ? 'text-white' : '' }}">Kontak</a>
        </nav>
        <div class="flex items-center gap-2">
            @guest
                <span class="hidden items-center gap-1 text-[13px] font-semibold text-neutral-300 sm:flex">
                    <a href="{{ route('login') }}" class="px-2 py-2.5 transition hover:text-white">Masuk</a>
                    <span class="text-neutral-500" aria-hidden="true">/</span>
                    <a href="{{ route('register') }}" class="px-2 py-2.5 transition hover:text-white">Daftar</a>
                </span>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="hidden max-w-28 truncate px-3 py-2.5 text-[13px] font-semibold text-white sm:inline">{{ auth()->user()->name }}</a>
                <form method="post" action="{{ route('logout') }}" class="hidden sm:inline">
                    @csrf
                    <button type="submit" class="px-3 py-2.5 text-[13px] font-semibold text-neutral-200 transition hover:text-white">Keluar</button>
                </form>
            @endauth
            <a href="{{ route('kontak') }}" class="group hidden items-center gap-2 rounded-full px-6 py-2.5 text-[13px] font-bold text-white ring-1 ring-white/40 transition hover:bg-white/10 hover:ring-white md:inline-flex">
                Mulai Proyek
                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <button type="button" data-toggle aria-expanded="false" aria-controls="drawer" aria-label="Buka menu" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-white hover:bg-white/10 lg:hidden">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>
    <div id="drawer" data-drawer class="hidden border-t border-white/10 bg-navy-950/95 backdrop-blur lg:hidden">
        <nav class="space-y-1 px-4 py-4 text-sm font-semibold text-neutral-200" aria-label="Navigasi seluler">
            <a href="{{ url('/') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Beranda</a>
            <a href="{{ url('/#layanan') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Layanan</a>
            <a href="{{ url('/#solusi') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Solusi</a>
            <a href="{{ url('/#portofolio') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Portofolio</a>
            <a href="{{ url('/#tentang') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Tentang</a>
            @guest
                <a href="{{ route('login') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Masuk</a>
                <a href="{{ route('register') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Daftar</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="block truncate rounded-xl px-3 py-2.5 text-white">{{ auth()->user()->name }}</a>
            @endauth
            <a href="{{ route('kontak') }}" class="mt-2 flex items-center justify-center gap-2 rounded-full px-3 py-2.5 font-bold text-white ring-1 ring-white/40">Mulai Proyek</a>
        </nav>
    </div>
</header>

<main id="main" class="{{ $isHome ? '' : 'pt-[72px]' }}">
    @yield('content')
</main>

{{-- ============ FOOTER ============ --}}
<footer class="relative overflow-hidden bg-navy-950 pb-10 pt-16 text-sm text-neutral-400">
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6">
        <div class="grid gap-12 pb-14 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <a href="{{ url('/') }}" class="leading-tight">
                    <span class="block text-xl font-extrabold tracking-tight text-white">Nusakode<span class="text-brand-400">.</span></span>
                    <span class="block text-[10px] font-semibold uppercase tracking-[0.18em] text-neutral-500">PT Nusakode Teknologi</span>
                </a>
                <p class="mt-5 max-w-xs text-[13px] leading-relaxed">Perusahaan jasa teknologi informasi di Jakarta. Membangun aplikasi, sistem, dan infrastruktur TI bersama tim Anda sejak 2015.</p>
                <p class="mt-5 flex items-center gap-2 text-xs font-semibold text-neutral-300">
                    <svg class="h-4 w-4 text-brand-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    Proses kerja berstandar ISO 27001
                </p>
            </div>
            <nav aria-label="Tautan layanan">
                <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Layanan</h3>
                <ul class="mt-5 space-y-3 text-[13px]">
                    <li><a href="{{ url('/#layanan') }}" class="transition hover:text-white">Pengembangan Aplikasi Web</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="transition hover:text-white">Sistem Informasi &amp; ERP</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="transition hover:text-white">Integrasi Sistem &amp; API</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="transition hover:text-white">Infrastruktur &amp; Cloud</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="transition hover:text-white">Keamanan Informasi</a></li>
                </ul>
            </nav>
            <nav aria-label="Tautan perusahaan">
                <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Perusahaan</h3>
                <ul class="mt-5 space-y-3 text-[13px]">
                    <li><a href="{{ url('/#tentang') }}" class="transition hover:text-white">Tentang Kami</a></li>
                    <li><a href="{{ url('/#portofolio') }}" class="transition hover:text-white">Portofolio</a></li>
                    <li><a href="{{ url('/#insight') }}" class="transition hover:text-white">Insight</a></li>
                </ul>
            </nav>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Hubungi Kami</h3>
                <ul class="mt-5 space-y-3 text-[13px]">
                    <li><a href="mailto:halo@nusakode.id" class="transition hover:text-white">halo@nusakode.id</a></li>
                    <li><a href="tel:+622150001234" class="transition hover:text-white">+62 21 5000 1234</a></li>
                    <li>Jakarta Selatan, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-8 text-xs text-neutral-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} PT Nusakode Teknologi. Seluruh hak cipta dilindungi.</p>
            <nav class="flex items-center gap-6" aria-label="Tautan legal">
                <a href="{{ url('/') }}" class="transition hover:text-white">Kebijakan Privasi</a>
                <a href="{{ url('/') }}" class="transition hover:text-white">Syarat &amp; Ketentuan</a>
            </nav>
        </div>
    </div>

    <div class="pointer-events-none absolute inset-x-0 -bottom-8 select-none overflow-hidden" aria-hidden="true">
        <p class="whitespace-nowrap text-center text-[20vw] font-extrabold leading-[0.8] tracking-tight text-white/[0.05]">Nusakode</p>
    </div>
</footer>

{{-- Ganti nomor di bawah dengan nomor WhatsApp admin (format: kode negara + nomor, tanpa +/spasi) --}}
<a href="https://wa.me/622150001234?text=Halo%20Nusakode%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener" aria-label="Chat via WhatsApp"
    class="group fixed bottom-10 right-10 z-50 flex h-16 w-16 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-emerald-900/25 transition duration-300 hover:scale-105 hover:bg-[#1faa53]">
    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#25D366] opacity-20" aria-hidden="true"></span>
    <svg class="relative h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

</body>
</html>
