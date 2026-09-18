@extends('layouts.site')

@section('title', $article->seo_title ?: $article->title.' — Nusakode')
@section('meta-description', $article->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?? $article->body ?? $article->title), 160))
@if ($article->featured_image_path)
    @section('og-image', str_starts_with($article->featured_image_path, 'img/') ? asset($article->featured_image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($article->featured_image_path))
@endif

@section('content')
    <article>
        <div class="mx-auto max-w-3xl px-4 sm:px-6">
            <div class="py-20 sm:py-24">
                <p class="flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-[0.2em]">
                    <a href="{{ route('blog.index') }}" class="text-navy-950 transition hover:text-brand-700">Blog</a>
                    <span class="text-neutral-300" aria-hidden="true">/</span>
                    <span class="text-neutral-400">{{ $article->categoryName() }}</span>
                </p>
                <h1 class="mt-6 text-3xl font-extrabold leading-tight tracking-tight text-balance text-navy-950 sm:text-5xl">{{ $article->title }}</h1>
                <p class="mt-6 flex flex-wrap items-center gap-x-4 gap-y-1 text-[13px] text-neutral-500">
                    <span>{{ ($article->published_at ?? $article->created_at)?->translatedFormat('d F Y') }}</span>
                    <span aria-hidden="true">·</span>
                    <span>{{ $article->readingTime() }} menit baca</span>
                    @if ($article->author)
                        <span aria-hidden="true">·</span>
                        <span>{{ $article->author->name }}</span>
                    @endif
                </p>
            </div>
        </div>

        @php($img = $article->featured_image_path ? (str_starts_with($article->featured_image_path, 'img/') ? asset($article->featured_image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($article->featured_image_path)) : null)
        @if ($img)
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <img src="{{ $img }}" alt="{{ $article->title }}" class="aspect-[16/8] w-full object-cover" loading="lazy">
            </div>
        @endif

        <div class="mx-auto max-w-3xl px-4 py-14 sm:px-6">
            @if ($article->excerpt)
                <p class="border-l-2 border-brand-600 pl-5 text-lg font-medium leading-relaxed text-navy-950">{{ $article->excerpt }}</p>
            @endif
            <div class="prose-mt mt-8 whitespace-pre-line text-[15px] leading-relaxed text-neutral-600">{{ $article->body ?: 'Isi artikel segera hadir.' }}</div>

            @if ($article->tagList())
                <ul class="mt-10 flex flex-wrap gap-2" aria-label="Tag">
                    @foreach ($article->tagList() as $tag)
                        <li class="rounded-full border border-neutral-200 px-4 py-1.5 text-xs font-semibold text-neutral-500">{{ $tag }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="border-t border-neutral-100 bg-neutral-50/60 py-20 sm:py-24">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <h2 class="text-2xl font-extrabold tracking-tight text-navy-950">Artikel terkait</h2>
                <div class="mt-8 divide-y divide-neutral-200 border-y border-neutral-200">
                    @foreach ($related as $item)
                        <a href="{{ route('blog.show', $item->slug) }}" class="group flex items-center justify-between gap-6 py-5">
                            <span>
                                <span class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400">{{ $item->categoryName() }}</span>
                                <span class="mt-1 block font-bold tracking-tight text-navy-950 transition group-hover:text-brand-700">{{ $item->title }}</span>
                            </span>
                            <svg class="h-5 w-5 shrink-0 text-neutral-300 transition-all group-hover:translate-x-1 group-hover:text-navy-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
