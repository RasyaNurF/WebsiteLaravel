@php($crumbs = $items ?: [['label' => 'Dashboard']])

<nav class="min-w-0 flex-1" aria-label="Breadcrumb">
    <ol class="flex min-w-0 items-center gap-1.5 text-[13px]">
        @foreach ($crumbs as $crumb)
            @if (! $loop->first)
                <li class="shrink-0" aria-hidden="true"><x-admin.icon name="chevron-right" class="h-3.5 w-3.5 text-neutral-300" /></li>
            @endif
            <li class="min-w-0 {{ $loop->last ? '' : 'shrink-0' }}">
                @if (($crumb['url'] ?? null) && ! $loop->last)
                    <a href="{{ $crumb['url'] }}" class="block truncate font-medium text-neutral-500 transition hover:text-neutral-900">{{ $crumb['label'] }}</a>
                @else
                    <span class="block truncate font-semibold text-neutral-900" aria-current="page">{{ $crumb['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
