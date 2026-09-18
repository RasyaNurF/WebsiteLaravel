<section {{ $attributes->merge(['class' => 'rounded-lg border border-neutral-200 bg-white']) }}>
    @if ($title || isset($actions))
        <header class="flex flex-wrap items-center justify-between gap-3 border-b border-neutral-200 px-5 py-4">
            <div class="min-w-0">
                @if ($title)
                    <h2 class="text-[15px] font-semibold text-neutral-900">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="mt-0.5 text-[13px] text-neutral-500">{{ $description }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex shrink-0 items-center gap-2">{{ $actions }}</div>
            @endisset
        </header>
    @endif
    {{ $slot }}
</section>
