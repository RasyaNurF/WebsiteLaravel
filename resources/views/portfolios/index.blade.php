@extends('layouts.site')

@section('title', 'Portfolio — Nusakode')
@section('meta-description', 'Portfolio Nusakode: sistem dan aplikasi yang sudah berjalan produksi untuk perbankan, distribusi, pendidikan, dan pemerintahan.')

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-3xl py-20 sm:py-28">
                <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.24em] text-navy-950"><span class="h-px w-10 bg-brand-600" aria-hidden="true"></span>Portfolio</p>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-balance text-navy-950 sm:text-6xl">Pekerjaan yang sudah berjalan produksi.</h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-500">Setiap proyek diserahterimakan penuh: kode sumber, dokumentasi, dan pelatihan operator.</p>
            </div>
        </div>
    </section>

    @if ($categories->isNotEmpty())
        <section class="border-y border-neutral-100 bg-neutral-50/60" aria-label="Filter kategori">
            <div class="mx-auto flex max-w-7xl flex-wrap gap-2 px-4 py-5 sm:px-6">
                <a href="{{ route('portfolio.index') }}" class="rounded-full px-5 py-2 text-[13px] font-bold transition {{ $activeCategory ? 'text-neutral-500 hover:text-navy-950' : 'bg-navy-950 text-white' }}">Semua</a>
                @foreach ($categories as $category)
                    <a href="{{ route('portfolio.index', ['kategori' => $category]) }}" class="rounded-full px-5 py-2 text-[13px] font-bold transition {{ $activeCategory === $category ? 'bg-navy-950 text-white' : 'text-neutral-500 hover:text-navy-950' }}">{{ $category }}</a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            @if ($portfolios->isEmpty())
                <div class="border border-dashed border-neutral-300 px-6 py-20 text-center">
                    <p class="text-lg font-bold text-navy-950">Belum ada portfolio pada kategori ini.</p>
                    <p class="mt-2 text-sm text-neutral-500">Coba pilih kategori lain atau hubungi kami untuk studi kasus serupa.</p>
                    <a href="{{ route('kontak') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-brand-500">Diskusikan Proyek Serupa</a>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($portfolios as $portfolio)
                        <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="group relative block overflow-hidden rounded-2xl">
                            @php($thumb = $portfolio->thumbnail_path ? (str_starts_with($portfolio->thumbnail_path, 'img/') ? asset($portfolio->thumbnail_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($portfolio->thumbnail_path)) : asset('img/work-1.jpg'))
                            <img src="{{ $thumb }}" alt="{{ $portfolio->title }}" class="h-72 w-full object-cover transition duration-700 group-hover:scale-[1.06]" loading="lazy">
                            <span class="absolute inset-0 bg-gradient-to-t from-navy-950/90 via-navy-950/25 to-transparent" aria-hidden="true"></span>
                            <span class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                                <span class="block text-[11px] font-bold uppercase tracking-[0.2em] text-brand-400">{{ $portfolio->category ?: $portfolio->client?->industry ?: 'Portfolio' }}</span>
                                <span class="mt-1.5 block text-lg font-bold leading-snug text-white">{{ $portfolio->title }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
