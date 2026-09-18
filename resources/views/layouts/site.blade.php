<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Nusakode — Perusahaan Jasa Teknologi Informasi Indonesia')</title>
    <meta name="description" content="@yield('meta-description', 'PT Nusakode Teknologi: jasa pengembangan aplikasi web, sistem informasi, integrasi sistem, infrastruktur cloud, dan keamanan informasi untuk perusahaan di Indonesia.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og-type', 'website')">
    <meta property="og:site_name" content="Nusakode">
    <meta property="og:title" content="@yield('og-title', trim($__env->yieldContent('title', 'Nusakode — Perusahaan Jasa Teknologi Informasi Indonesia')))">
    <meta property="og:description" content="@yield('og-description', trim($__env->yieldContent('meta-description', 'PT Nusakode Teknologi: jasa pengembangan aplikasi web, sistem informasi, integrasi sistem, infrastruktur cloud, dan keamanan informasi untuk perusahaan di Indonesia.')))">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og-image')
        <meta property="og:image" content="@yield('og-image')">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og-title', trim($__env->yieldContent('title', 'Nusakode — Perusahaan Jasa Teknologi Informasi Indonesia')))">
    <meta name="twitter:description" content="@yield('og-description', trim($__env->yieldContent('meta-description', 'PT Nusakode Teknologi: jasa pengembangan aplikasi web, sistem informasi, integrasi sistem, infrastruktur cloud, dan keamanan informasi untuk perusahaan di Indonesia.')))">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-neutral-700">

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-3 focus:top-3 focus:z-[100] focus:bg-white focus:px-4 focus:py-2 focus:text-sm">Lewati ke konten</a>

{{-- ============ NAVIGASI KACA (global) ============ --}}
@php($isHome = request()->is('/'))
<header id="glass-header" @if ($isHome) data-transparent-top @endif class="fixed inset-x-0 top-0 z-50 transition duration-300 {{ $isHome ? '' : 'border-b border-white/10 bg-navy-950/80 shadow-sm backdrop-blur' }}">
    <div id="promo-banner" data-promo class="bg-brand-600 text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-center gap-3 px-4 py-2 sm:px-6">
            <p class="truncate text-[13px] font-medium">Butuh software, website, atau aplikasi mobile untuk bisnis Anda? <a href="{{ route('kontak') }}" class="font-bold underline decoration-white/50 underline-offset-2 transition hover:decoration-white">Konsultasi gratis</a></p>
            <button type="button" data-promo-close aria-label="Tutup pengumuman" class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-white/80 transition hover:bg-white/15 hover:text-white">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ url('/') }}" class="text-xl font-extrabold tracking-[0.18em] text-white">NUSAKODE<span class="text-brand-400">.</span></a>
        <nav class="hidden items-center gap-8 text-[13px] font-semibold text-neutral-200 lg:flex" aria-label="Navigasi utama">
            <a href="{{ url('/') }}" class="relative pb-1.5 transition hover:text-white {{ $isHome ? 'text-white' : '' }}">Beranda @if ($isHome)<span class="absolute inset-x-0 -bottom-0.5 h-0.5 bg-brand-500" aria-hidden="true"></span>@endif</a>
            <div class="group relative">
                <a href="{{ route('solusi.index') }}" class="flex items-center gap-1 pb-1.5 transition hover:text-white {{ request()->routeIs('solusi*') ? 'text-white' : '' }}" aria-haspopup="true">Solusi

                    <svg class="h-3.5 w-3.5 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </a>
                <div class="invisible absolute left-1/2 top-full w-[560px] max-w-[calc(100vw-2rem)] -translate-x-1/2 translate-y-2 pt-4 opacity-0 transition duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    <div class="overflow-hidden rounded-2xl bg-navy-950 text-left shadow-2xl shadow-navy-950/40 ring-1 ring-white/10">
                        <div class="grid grid-cols-2 gap-1 p-3">
                                        @forelse (($navSolutionCategories ?? collect()) as $navCategory)

                <a href="{{ route('solusi.category', $navCategory->slug) }}" class="rounded-xl px-4 py-3 transition hover:bg-white/10">
                    <span class="block text-sm font-bold text-white">{{ $navCategory->name }}</span>
                    <span class="mt-0.5 block truncate text-xs text-neutral-400">{{ \Illuminate\Support\Str::limit($navCategory->tagline ?? $navCategory->description ?? 'Solusi untuk kebutuhan bisnis Anda.', 64) }}</span>
                </a>
            @empty
                @foreach (['Human Capital Management' => 'SDM, payroll, dan talenta.', 'CRM & Customer Experience' => 'Layanan dan penjualan pelanggan.', 'Infrastruktur TI' => 'Cloud, monitoring, dan dokumen.', 'IT Security' => 'Perlindungan endpoint dan data.', 'ERP & Business Intelligence' => 'ERP dan analitik bisnis.'] as $title => $desc)
                    <a href="{{ route('solusi.index') }}" class="rounded-xl px-4 py-3 transition hover:bg-white/10">
                        <span class="block text-sm font-bold text-white">{{ $title }}</span>
                        <span class="mt-0.5 block truncate text-xs text-neutral-400">{{ $desc }}</span>
                    </a>
                @endforeach
            @endforelse

                        </div>
                        <a href="{{ route('kontak') }}" class="group/cta flex items-center justify-between gap-4 bg-white/5 px-6 py-3.5 text-[13px] font-bold text-white transition hover:bg-white/10">
                            Butuh solusi yang disesuaikan? Konsultasi gratis
                            <svg class="h-4 w-4 transition-transform group-hover/cta:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <a href="{{ route('layanan.index') }}" class="pb-1.5 transition hover:text-white {{ request()->routeIs('layanan*') ? 'text-white' : '' }}">Layanan</a>
            <a href="{{ route('portfolio.index') }}" class="pb-1.5 transition hover:text-white {{ request()->routeIs('portfolio*') ? 'text-white' : '' }}">Portfolio</a>
            <div class="group relative">
                <a href="{{ route('tentang') }}" class="flex items-center gap-1 pb-1.5 transition hover:text-white {{ request()->routeIs('tentang', 'karier*') ? 'text-white' : '' }}" aria-haspopup="true">Perusahaan
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </a>
                <div class="invisible absolute left-1/2 top-full w-56 -translate-x-1/2 translate-y-2 pt-4 opacity-0 transition duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    <div class="overflow-hidden rounded-2xl bg-navy-950 p-2 text-left shadow-2xl shadow-navy-950/40 ring-1 ring-white/10">
                        <a href="{{ route('tentang') }}" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Tentang Kami</a>
                        <a href="{{ route('karier.index') }}" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Karier</a>
                    </div>
                </div>
            </div>
            <div class="group relative">
                <a href="{{ route('resources.index') }}" class="flex items-center gap-1 pb-1.5 transition hover:text-white {{ request()->routeIs('resources*') ? 'text-white' : '' }}" aria-haspopup="true">Resources

                    <svg class="h-3.5 w-3.5 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </a>
                <div class="invisible absolute left-1/2 top-full w-56 -translate-x-1/2 translate-y-2 pt-4 opacity-0 transition duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    <div class="overflow-hidden rounded-2xl bg-navy-950 p-2 text-left shadow-2xl shadow-navy-950/40 ring-1 ring-white/10">
                        <a href="{{ route('resources.events') }}"
 class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Event</a>
                        <a href="{{ route('resources.whitepaper') }}"
 class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Whitepaper</a>
                        <a href="{{ route('resources.e-book') }}"
 class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">E-book</a>
                        <a href="{{ route('resources.news') }}"
 class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">News</a>
                        <a href="{{ route('resources.go-live') }}"
 class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Go-Live</a>
                        <a href="{{ route('blog.index') }}" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Blog</a>


                    </div>

                </div>
            </div>
        </nav>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="hidden max-w-28 truncate px-3 py-2.5 text-[13px] font-semibold text-white sm:inline">{{ auth()->user()->name }}</a>
                <form method="post" action="{{ route('logout') }}" class="hidden sm:inline">
                    @csrf
                    <button type="submit" class="px-3 py-2.5 text-[13px] font-semibold text-neutral-200 transition hover:text-white">Keluar</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="hidden px-3 py-2.5 text-[13px] font-semibold text-neutral-200 transition hover:text-white sm:inline">Masuk</a>
                <a href="{{ route('register') }}" class="hidden items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-[13px] font-bold text-white transition hover:bg-brand-500 sm:inline-flex">Daftar</a>
            @endguest
            <a href="{{ route('kontak') }}" class="group hidden items-center gap-2 rounded-full px-6 py-2.5 text-[13px] font-bold text-white ring-1 ring-white/40 transition hover:bg-white/10 hover:ring-white md:inline-flex">
                Hubungi Kami

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
            <a href="{{ route('layanan.index') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Layanan</a>
            <p class="px-3 pb-1 pt-3 text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-500">Solusi</p>
                        @forelse (($navSolutionCategories ?? collect()) as $navCategory)

                <a href="{{ route('solusi.category', $navCategory->slug) }}" class="rounded-xl px-4 py-3 transition hover:bg-white/10">
                    <span class="block text-sm font-bold text-white">{{ $navCategory->name }}</span>
                    <span class="mt-0.5 block truncate text-xs text-neutral-400">{{ \Illuminate\Support\Str::limit($navCategory->tagline ?? $navCategory->description ?? 'Solusi untuk kebutuhan bisnis Anda.', 64) }}</span>
                </a>
            @empty
                @foreach (['Human Capital Management' => 'SDM, payroll, dan talenta.', 'CRM & Customer Experience' => 'Layanan dan penjualan pelanggan.', 'Infrastruktur TI' => 'Cloud, monitoring, dan dokumen.', 'IT Security' => 'Perlindungan endpoint dan data.', 'ERP & Business Intelligence' => 'ERP dan analitik bisnis.'] as $title => $desc)
                    <a href="{{ route('solusi.index') }}" class="rounded-xl px-4 py-3 transition hover:bg-white/10">
                        <span class="block text-sm font-bold text-white">{{ $title }}</span>
                        <span class="mt-0.5 block truncate text-xs text-neutral-400">{{ $desc }}</span>
                    </a>
                @endforeach
            @endforelse

            <a href="{{ route('portfolio.index') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Portfolio</a>
            <p class="px-3 pb-1 pt-3 text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-500">Perusahaan</p>
            <a href="{{ route('tentang') }}" class="block rounded-xl px-3 py-2 pl-6 text-[13px] font-medium text-neutral-300 hover:bg-white/10">Tentang Kami</a>
            <a href="{{ route('karier.index') }}" class="block rounded-xl px-3 py-2 pl-6 text-[13px] font-medium text-neutral-300 hover:bg-white/10">Karier</a>
            <p class="px-3 pb-1 pt-3 text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-500">Resources</p>
            <a href="{{ route('blog.index') }}" class="block rounded-xl px-3 py-2 pl-6 text-[13px] font-medium text-neutral-300 hover:bg-white/10">Blog</a>
            @foreach(\App\Enums\ResourceType::cases() as $resourceType)
                <a href="{{ route('resources.type', $resourceType->value) }}" class="block rounded-xl px-3 py-2 pl-6 text-[13px] font-medium text-neutral-300 hover:bg-white/10">{{ $resourceType->label() }}</a>
            @endforeach


                        @auth

                <a href="{{ route('dashboard') }}" class="block truncate rounded-xl px-3 py-2.5 text-white">{{ auth()->user()->name }}</a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Masuk</a>
                <a href="{{ route('register') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/10">Daftar</a>
            @endguest
            <a href="{{ route('kontak') }}" class="mt-2 flex items-center justify-center gap-2 rounded-full px-3 py-2.5 font-bold text-white ring-1 ring-white/40">Mulai Proyek</a>

        </nav>
    </div>
</header>

<main id="main" class="{{ $isHome ? '' : 'pt-[112px]' }}">
    @yield('content')
</main>

{{-- ============ FOOTER ============ --}}
<footer class="relative overflow-hidden bg-navy-950 pb-10 pt-16 text-sm text-neutral-400">
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6">
        <div class="grid gap-12 pb-14 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr_1.2fr]">
            <div>
                <a href="{{ url('/') }}" class="leading-tight">
                    <span class="block text-xl font-extrabold tracking-tight text-white">Nusakode<span class="text-brand-400">.</span></span>
                    <span class="block text-[10px] font-semibold uppercase tracking-[0.18em] text-neutral-500">PT Nusakode Teknologi</span>
                </a>
                <p class="mt-5 max-w-xs text-[13px] leading-relaxed">Perusahaan jasa teknologi informasi di Jakarta. Membangun aplikasi, sistem, dan infrastruktur TI bersama tim Anda sejak 2015.</p>
            </div>
                            <nav aria-label="Tautan solusi">
                    <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Solusi</h3>
                    <ul class="mt-5 space-y-3 text-[13px]">
                        @forelse (($navSolutionCategories ?? collect()) as $navCategory)

                            <li><a href="{{ route('solusi.category', $navCategory->slug) }}" class="transition hover:text-white">{{ $navCategory->name }}</a></li>
                        @empty
                            <li><a href="{{ route('solusi.index') }}" class="transition hover:text-white">Semua Solusi</a></li>
                        @endforelse
                        <li><a href="{{ route('layanan.index') }}" class="transition hover:text-white">Layanan</a></li>
                    </ul>
                </nav>

            <nav aria-label="Tautan perusahaan">
                <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Perusahaan</h3>
                <ul class="mt-5 space-y-3 text-[13px]">
                    <li><a href="{{ route('tentang') }}" class="transition hover:text-white">Tentang Kami</a></li>
                    <li><a href="{{ route('karier.index') }}" class="transition hover:text-white">Karier</a></li>
                    <li><a href="{{ route('kontak') }}" class="transition hover:text-white">Kontak</a></li>
                </ul>
            </nav>
            <nav aria-label="Tautan resources">
                <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Resources</h3>
                <ul class="mt-5 space-y-3 text-[13px]">
                    <li><a href="{{ route('blog.index') }}" class="transition hover:text-white">Blog</a></li>
                    @foreach(\App\Enums\ResourceType::cases() as $resourceType)
                        <li><a href="{{ route('resources.type', $resourceType->value) }}" class="transition hover:text-white">{{ $resourceType->label() }}</a></li>
                    @endforeach
                    <li><a href="{{ route('karier.index') }}" class="transition hover:text-white">Karier</a></li>

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
