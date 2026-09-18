@extends('layouts.site')

@section('title', 'Resources — Nusakode')
@section('meta-description', 'Kumpulan Event, Whitepaper, E-book, News, dan Go-Live dari tim Nusakode beserta mitra teknologi.')

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-3xl py-20 sm:py-28">
                <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.24em] text-navy-950"><span class="h-px w-10 bg-brand-600" aria-hidden="true"></span>Resources</p>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-balance text-navy-950 sm:text-6xl">Belajar dari pengalaman dan kolaborasi kami.</h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-500">Event, panduan, laporan, dan kabar terbaru seputar teknologi enterprise di Indonesia.</p>
            </div>
        </div>
    </section>

    <section class="border-t border-neutral-100">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <nav class="flex flex-wrap gap-2" aria-label="Kategori resources">
                @foreach($types as $type)
                    <a href="{{route('resources.type',$type->value)}}" class="rounded-full px-4 py-2 text-[13px] font-bold text-neutral-500 ring-1 ring-neutral-200 transition hover:text-navy-950 hover:ring-neutral-300">{{$type->label()}}</a>
                @endforeach
            </nav>
        </div>
    </section>

    @if($resources->isEmpty())
        <section class="border-t border-neutral-100">
            <div class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6 sm:py-28">
                <p class="text-lg font-bold text-navy-950">Belum ada resource.</p>
            </div>
        </section>
    @else
        <section class="border-t border-neutral-100">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($resources as $resource)
                        <article class="group flex flex-col">
                            <a href="{{route('resources.show',[$resource->type->value,$resource->slug])}}" class="block overflow-hidden rounded-2xl bg-neutral-100">
                                @if($resource->cover_image_path)
                                    <img src="{{str_starts_with($resource->cover_image_path,'img/')?asset($resource->cover_image_path):\Illuminate\Support\Facades\Storage::disk('public')->url($resource->cover_image_path)}}" alt="{{$resource->title}}" class="h-52 w-full object-cover transition duration-700 group-hover:scale-[1.04]" loading="lazy">
                                @else
                                    <div class="flex h-52 w-full items-center justify-center bg-navy-950"><span class="text-sm font-bold uppercase tracking-[0.2em] text-white/30">{{$resource->type->label()}}</span></div>
                                @endif
                            </a>
                            <div class="mt-5 flex flex-1 flex-col">
                                <a href="{{route('resources.type',$resource->type->value)}}" class="text-[11px] font-bold uppercase tracking-[0.18em] text-brand-700 transition hover:text-brand-800">{{$resource->type->label()}}</a>
                                <h2 class="mt-2 text-lg font-bold leading-snug tracking-tight text-navy-950"><a href="{{route('resources.show',[$resource->type->value,$resource->slug])}}" class="transition hover:text-brand-700">{{$resource->title}}</a></h2>
                                @if($resource->excerpt)
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-neutral-500">{{\Illuminate\Support\Str::limit($resource->excerpt, 140)}}</p>
                                @endif
                                <p class="mt-4 text-xs font-semibold text-neutral-400">{{$resource->published_at?->translatedFormat('d F Y')?:'—'}}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="mx-auto max-w-7xl px-4 pb-20 sm:px-6">{{$resources->links()}}</div>
    @endif
@endsection
