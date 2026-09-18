@extends('layouts.site')

@section('title', $service->title.' — Nusakode')
@section('meta-description', \Illuminate\Support\Str::limit($service->description ?? $service->title, 160))

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-3xl py-20 sm:py-28">
                <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.24em] text-navy-950">
                    <a href="{{ route('layanan.index') }}" class="transition hover:text-brand-700">Layanan</a>
                    <span class="text-neutral-300" aria-hidden="true">/</span>
                    <span class="text-neutral-400">{{ $service->title }}</span>
                </p>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-balance text-navy-950 sm:text-5xl">{{ $service->title }}</h1>
                @if ($service->description)
                    <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-500">{{ $service->description }}</p>
                @endif
                @if ($service->technologyList())
                    <p class="mt-6 text-[13px] font-medium text-neutral-400">{!! implode(' &nbsp;·&nbsp; ', array_map('e', $service->technologyList())) !!}</p>
                @endif
                <div class="mt-8">
                    <a href="{{ route('kontak') }}" class="group inline-flex items-center gap-2 rounded-full bg-brand-600 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-brand-500">
                        Diskusikan kebutuhan ini
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if ($service->image_path)
        <section aria-label="Ilustrasi {{ $service->title }}">
            <img src="{{ str_starts_with($service->image_path, 'img/') ? asset($service->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($service->image_path) }}" alt="{{ $service->title }}" class="h-72 w-full object-cover sm:h-[420px]" loading="lazy">
        </section>
    @endif

    @if ($related->isNotEmpty())
        <section class="border-t border-neutral-100 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="text-2xl font-extrabold tracking-tight text-navy-950 sm:text-3xl">Layanan terkait</h2>
                    <a href="{{ route('layanan.index') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-navy-800">
                        Semua layanan
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
                <div class="mt-10 grid gap-px overflow-hidden rounded-2xl border border-neutral-200 bg-neutral-200 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('layanan.show', $item->slug) }}" class="group bg-white p-8 transition hover:bg-neutral-50">
                            <h3 class="text-lg font-bold tracking-tight text-navy-950 transition group-hover:text-brand-700">{{ $item->title }}</h3>
                            @if ($item->description)
                                <p class="mt-2 text-sm leading-relaxed text-neutral-500">{{ \Illuminate\Support\Str::limit($item->description, 120) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
