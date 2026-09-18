<header class="flex flex-col gap-4 border-b border-neutral-200 pb-6 sm:flex-row sm:items-end sm:justify-between">
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-brand-600">{{ $eyebrow }}</p>
        @endif
        <h1 class="text-[22px] font-bold tracking-tight text-neutral-900 sm:text-2xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1.5 max-w-2xl text-sm leading-relaxed text-neutral-500">{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</header>
