@extends('layouts.site')

@section('title', 'Blog — Nusakode')
@section('meta-description', 'Tulisan praktis dari tim Nusakode: panduan proyek software, keamanan, dan operasional.')

@section('content')
    <section class="bg-navy-950 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="py-20 sm:py-28">
                <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.24em]"><span class="h-px w-10 bg-brand-500" aria-hidden="true"></span>Blog</p>
                <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-[1.05] tracking-tight text-balance sm:text-6xl">Tulisan praktis dari tim kami.</h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-300">Insight seputar pengembangan software, keamanan informasi, dan operasional teknologi untuk perusahaan di Indonesia.</p>

                <form action="{{ route('blog.index') }}" method="get" class="mt-10 max-w-xl">
                    @if($activeCategory)<input type="hidden" name="kategori" value="{{$activeCategory}}">@endif
                    <label for="blog-search" class="sr-only">Cari artikel</label>
                    <div class="relative">
                        <x-admin.icon name="search" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400" />

                        <input id="blog-search" type="search" name="q" value="{{request('q')}}" placeholder="Cari artikel…"
                            class="h-12 w-full rounded-full border border-white/15 bg-white/5 pl-11 pr-4 text-sm text-white outline-none transition placeholder:text-neutral-400 focus:border-brand-500 focus:bg-white/10 focus:ring-2 focus:ring-brand-500/30">
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if($categories->isNotEmpty())
        <section class="border-b border-neutral-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <nav class="flex flex-wrap gap-2 py-6" aria-label="Filter kategori">
                    <a href="{{route('blog.index')}}" class="rounded-full px-5 py-2 text-[13px] font-bold transition {{$activeCategory?'text-neutral-500 ring-1 ring-neutral-200 hover:text-navy-950 hover:ring-neutral-300':'bg-navy-950 text-white'}}">Semua</a>
                    @foreach($categories as $category)
                        <a href="{{route('blog.index',['kategori'=>$category->slug])}}" class="rounded-full px-5 py-2 text-[13px] font-bold transition {{$activeCategory===$category->slug?'bg-navy-950 text-white':'text-neutral-500 ring-1 ring-neutral-200 hover:text-navy-950 hover:ring-neutral-300'}}">{{$category->name}}</a>
                    @endforeach
                </nav>
            </div>
        </section>
    @endif

    <section class="pb-20 sm:pb-28">
        <div class="mx-auto max-w-7xl px-4 pt-12 sm:px-6 sm:pt-16">
            @if($articles->isEmpty())
                <div class="rounded-2xl border border-dashed border-neutral-300 px-6 py-20 text-center">
                    <p class="text-lg font-bold text-navy-950">Belum ada artikel.</p>
                    <p class="mt-2 text-sm text-neutral-500">Artikel pada kategori ini segera hadir.</p>
                    <a href="{{route('blog.index')}}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-brand-500">Lihat Semua Artikel</a>
                </div>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($articles as $article)
                        <article class="group flex flex-col">
                            <a href="{{route('blog.show',$article->slug)}}" class="block overflow-hidden rounded-2xl bg-neutral-100">
                                @php($img=$article->featured_image_path?(str_starts_with($article->featured_image_path,'img/')?asset($article->featured_image_path):\Illuminate\Support\Facades\Storage::disk('public')->url($article->featured_image_path)):null)
                                @if($img)
                                    <img src="{{$img}}" alt="{{$article->title}}" class="aspect-[16/9] w-full object-cover transition duration-700 group-hover:scale-[1.04]" loading="lazy">
                                @else
                                    <div class="flex aspect-[16/9] w-full items-center justify-center bg-navy-950"><span class="text-xs font-bold uppercase tracking-[0.2em] text-white/30">{{$article->categoryName()}}</span></div>
                                @endif
                            </a>
                            <div class="mt-5 flex flex-1 flex-col">
                                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-brand-700">{{$article->categoryName()}}<span class="text-neutral-300"> · </span><span class="text-neutral-400">{{($article->published_at??$article->created_at)?->translatedFormat('d M Y')}}</span></p>
                                <h2 class="mt-2 text-lg font-bold leading-snug tracking-tight text-navy-950"><a href="{{route('blog.show',$article->slug)}}" class="transition hover:text-brand-700">{{$article->title}}</a></h2>
                                @if($article->excerpt)
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-neutral-500">{{\Illuminate\Support\Str::limit($article->excerpt,140)}}</p>
                                @endif
                                <div class="mt-4 flex items-center gap-3 text-xs font-semibold text-neutral-400">
                                    <span>{{$article->readingTime()}} menit baca</span>
                                    @if($article->author)<span aria-hidden="true">·</span><span>{{$article->author->name}}</span>@endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-14">
                    {{$articles->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
