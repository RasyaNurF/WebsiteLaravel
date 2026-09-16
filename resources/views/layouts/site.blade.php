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

{{-- ============ BILAH ATAS ============ --}}
<div class="bg-navy-950 text-xs text-neutral-300">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 sm:px-6">
        <div class="flex min-w-0 items-center gap-5">
            <a href="mailto:halo@nusakode.id" class="transition hover:text-white">halo@nusakode.id</a>
            <a href="tel:+622150001234" class="transition hover:text-white">+62 21 5000 1234</a>
        </div>
        <div class="flex shrink-0 items-center gap-4">
            <span class="hidden text-neutral-500 md:inline">Senin–Jumat, 09.00–18.00 WIB</span>
            @guest
                <a href="{{ route('login') }}" class="font-semibold text-white transition hover:text-brand-400">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-full bg-white/10 px-4 py-1.5 font-semibold text-white transition hover:bg-white/20">Daftar</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="max-w-28 truncate font-semibold text-white transition hover:text-brand-400">{{ auth()->user()->name }}</a>
                <form method="post" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="transition hover:text-white">Keluar</button>
                </form>
            @endauth
        </div>
    </div>
</div>

{{-- ============ NAVIGASI ============ --}}
<header id="site-header" class="sticky top-0 z-50 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ url('/') }}" class="leading-tight">
            <span class="block text-xl font-extrabold tracking-tight text-navy-900">Nusakode<span class="text-brand-600">.</span></span>
            <span class="block text-[10px] font-semibold uppercase tracking-[0.18em] text-neutral-400">PT Nusakode Teknologi</span>
        </a>

        <nav class="hidden items-center gap-8 text-sm font-semibold text-neutral-500 lg:flex" aria-label="Navigasi utama">
            <a href="{{ url('/#layanan') }}" class="transition hover:text-navy-900">Layanan</a>
            <a href="{{ url('/#solusi') }}" class="transition hover:text-navy-900">Solusi</a>
            <a href="{{ url('/#portofolio') }}" class="transition hover:text-navy-900">Portofolio</a>
            <a href="{{ url('/#tentang') }}" class="transition hover:text-navy-900">Tentang Kami</a>
            <a href="{{ url('/#insight') }}" class="transition hover:text-navy-900">Insight</a>
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('kontak') }}" class="hidden rounded-full bg-navy-800 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-navy-900 sm:inline-block">Konsultasi Gratis</a>
            <button type="button" data-toggle aria-expanded="false" aria-controls="drawer" aria-label="Buka menu" class="inline-flex h-10 w-10 items-center justify-center rounded-full hover:bg-neutral-100 lg:hidden">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>
    <div id="drawer" data-drawer class="hidden border-t border-neutral-100 bg-white lg:hidden">
        <nav class="space-y-1 px-4 py-4 text-sm font-semibold" aria-label="Navigasi seluler">
            <a href="{{ url('/#layanan') }}" class="block rounded-xl px-3 py-2.5 hover:bg-neutral-100">Layanan</a>
            <a href="{{ url('/#solusi') }}" class="block rounded-xl px-3 py-2.5 hover:bg-neutral-100">Solusi</a>
            <a href="{{ url('/#portofolio') }}" class="block rounded-xl px-3 py-2.5 hover:bg-neutral-100">Portofolio</a>
            <a href="{{ url('/#tentang') }}" class="block rounded-xl px-3 py-2.5 hover:bg-neutral-100">Tentang Kami</a>
            <a href="{{ url('/#insight') }}" class="block rounded-xl px-3 py-2.5 hover:bg-neutral-100">Insight</a>
            <a href="{{ route('kontak') }}" class="mt-2 block rounded-full bg-navy-800 px-3 py-2.5 text-center font-bold text-white">Konsultasi Gratis</a>
        </nav>
    </div>
</header>

<main id="main">
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
    class="fixed bottom-5 right-5 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg transition hover:scale-105 hover:bg-[#1faa53]">
    <svg class="h-7 w-7 fill-current" viewBox="0 0 448 512" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-32.4 1.8-4 1-8.6-1.5-11.7-12.5-15.2-28.5-13.6-37.5-12-2.3.4-5.2 1.9-6.9 4.2-16.7 22.7-21.4 53.9-2.2 82.4 22.2 33 50.7 55.3 71.2 66.1 15.1 8 30.2 10.4 41 8.9 11.4-1.6 32.8-13.4 37.4-26.4 1.7-4.8 3.5-9.9 1.2-14.4-2.2-4.4-8.1-5.8-13.6-8.6z"/></svg>
</a>

</body>
</html>
