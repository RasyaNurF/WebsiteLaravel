@extends('layouts.site')

@section('title', $portfolio->title.' — Nusakode')
@section('meta-description', \Illuminate\Support\Str::limit($portfolio->description ?? $portfolio->title, 160))

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-3xl py-20 sm:py-28">
                <p class="flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-[0.24em] text-navy-950">
                    <a href="{{ route('portfolio.index') }}" class="transition hover:text-brand-700">Portfolio</a>
                    <span class="text-neutral-300" aria-hidden="true">/</span>
                    <span class="text-neutral-400">{{ $portfolio->category ?: 'Studi kasus' }}</span>
                </p>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-balance text-navy-950 sm:text-5xl">{{ $portfolio->title }}</h1>
                @if ($portfolio->description)
                    <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-500">{{ $portfolio->description }}</p>
                @endif
                <dl class="mt-10 flex flex-wrap gap-x-12 gap-y-6 border-t border-neutral-200 pt-8 text-sm">
                    @if ($portfolio->client)
                        <div><dt class="text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-400">Klien</dt><dd class="mt-1 font-bold text-navy-950">{{ $portfolio->client->name }}</dd></div>
                    @endif
                    @if ($portfolio->year)
                        <div><dt class="text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-400">Tahun</dt><dd class="mt-1 font-bold tabular-nums text-navy-950">{{ $portfolio->year }}</dd></div>
                    @endif
                    @if ($portfolio->url)
                        <div><dt class="text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-400">Tautan</dt><dd class="mt-1"><a href="{{ $portfolio->url }}" target="_blank" rel="noopener" class="font-bold text-brand-700 hover:text-brand-600">Kunjungi situs</a></dd></div>
                    @endif
                </dl>
            </div>
        </div>
    </section>

    @php($thumb = $portfolio->thumbnail_path ? (str_starts_with($portfolio->thumbnail_path, 'img/') ? asset($portfolio->thumbnail_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($portfolio->thumbnail_path)) : null)
    @if ($thumb)
        <section aria-label="Thumbnail {{ $portfolio->title }}">
            <img src="{{ $thumb }}" alt="{{ $portfolio->title }}" class="h-72 w-full object-cover sm:h-[480px]" loading="lazy">
        </section>
    @endif

    <section class="py-20 sm:py-28">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)] lg:gap-20">
            <div class="space-y-12">
                @foreach (['challenge' => 'Tantangan', 'solution' => 'Solusi', 'result' => 'Hasil'] as $field => $label)
                    @if ($portfolio->$field)
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">{{ $label }}</p>
                            <div class="mt-4 whitespace-pre-line text-[15px] leading-relaxed text-neutral-600">{{ $portfolio->$field }}</div>
                        </div>
                    @endif
                @endforeach

                @if ($portfolio->images->isNotEmpty())
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Galeri</p>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ($portfolio->images as $image)
                                <figure>
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}" alt="{{ $image->caption ?: $portfolio->title }}" class="aspect-video w-full rounded-2xl border border-neutral-200 object-cover" loading="lazy">
                                    @if ($image->caption)
                                        <figcaption class="mt-2 text-xs text-neutral-500">{{ $image->caption }}</figcaption>
                                    @endif
                                </figure>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <aside>
                <div class="border border-neutral-200 bg-neutral-50/60 p-8">
                    <h2 class="text-base font-bold text-navy-950">Teknologi</h2>
                    @if ($portfolio->technologyList())
                        <ul class="mt-4 flex flex-wrap gap-2">
                            @foreach ($portfolio->technologyList() as $tech)
                                <li class="rounded-full border border-neutral-200 bg-white px-4 py-1.5 text-[13px] font-semibold text-neutral-600">{{ $tech }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-4 text-sm text-neutral-500">—</p>
                    @endif
                    <a href="{{ route('kontak') }}" class="mt-8 block rounded-full bg-navy-950 px-6 py-3.5 text-center text-sm font-bold text-white transition hover:bg-brand-600">Diskusikan proyek serupa</a>
                </div>
            </aside>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="border-t border-neutral-100 bg-neutral-50/60 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2 class="text-2xl font-extrabold tracking-tight text-navy-950 sm:text-3xl">Proyek terkait</h2>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('portfolio.show', $item->slug) }}" class="group relative block overflow-hidden rounded-2xl">
                            @php($rthumb = $item->thumbnail_path ? (str_starts_with($item->thumbnail_path, 'img/') ? asset($item->thumbnail_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($item->thumbnail_path)) : asset('img/work-1.jpg'))
                            <img src="{{ $rthumb }}" alt="{{ $item->title }}" class="h-64 w-full object-cover transition duration-700 group-hover:scale-[1.06]" loading="lazy">
                            <span class="absolute inset-0 bg-gradient-to-t from-navy-950/90 via-navy-950/25 to-transparent" aria-hidden="true"></span>
                            <span class="absolute inset-x-0 bottom-0 p-5">
                                <span class="block text-[11px] font-bold uppercase tracking-[0.2em] text-brand-400">{{ $item->category ?: 'Portfolio' }}</span>
                                <span class="mt-1.5 block text-lg font-bold leading-snug text-white">{{ $item->title }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
