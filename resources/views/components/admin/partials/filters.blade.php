{{-- Filter bar: search + filter selects + reset.
     Params: $action (route), $searchPlaceholder, $selects (array of ['name'=>,'label'=>,'options'=>[value=>label]]).
     Renders nothing when the page has neither search nor filters. --}}
@php
$selects = $selects ?? [];
$hasFilters = filled($searchPlaceholder) || $selects !== [];

$activeFilters = collect($selects)->pluck('name')
    ->filter(fn ($name) => request()->filled($name))
    ->all();

$isDirty = request()->filled('q') || $activeFilters !== [];
@endphp

@if ($hasFilters)
    <form method="get" action="{{ $action }}"
        class="flex flex-col gap-2 border-b border-neutral-200 px-4 py-3 sm:flex-row sm:items-center sm:px-5">
        @if (filled($searchPlaceholder))
            <div class="relative min-w-0 sm:w-64">
                <x-admin.icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400" />
                <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $searchPlaceholder }}"
                    class="h-9 w-full rounded-md border border-neutral-200 pl-9 pr-3 text-[13px] outline-none transition placeholder:text-neutral-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
            </div>
        @endif

        @foreach ($selects as $select)
            <div class="min-w-0 sm:w-44">
                <select name="{{ $select['name'] }}" onchange="this.form.submit()"
                    aria-label="{{ $select['label'] }}"
                    class="h-9 w-full rounded-md border border-neutral-200 bg-white pl-3 pr-8 text-[13px] text-neutral-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    <option value="">{{ $select['label'] }}</option>
                    @foreach ($select['options'] as $value => $label)
                        <option value="{{ $value }}" @selected((string) request($select['name']) === (string) $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <div class="flex items-center gap-1 sm:ml-auto">
            <button type="submit"
                class="h-9 shrink-0 rounded-md bg-neutral-900 px-4 text-[13px] font-semibold text-white transition hover:bg-neutral-800">Terapkan</button>
            @if ($isDirty)
                <a href="{{ $action }}"
                    class="flex h-9 shrink-0 items-center gap-1.5 rounded-md px-2.5 text-[13px] font-medium text-neutral-500 transition hover:bg-neutral-100 hover:text-neutral-900">
                    <x-admin.icon name="close" class="h-3.5 w-3.5" /> Reset
                </a>
            @endif
        </div>
    </form>
@endif
