{{-- Tombol utama/sekunder. Props: href (opsional), variant (primary|secondary|danger), type. --}}
@props(['href' => null, 'variant' => 'primary', 'type' => 'submit'])

@php
$base = 'inline-flex h-9 items-center justify-center gap-2 rounded-md px-4 text-[13px] font-semibold transition';
$classes = $base.' '.match ($variant) {
    'secondary' => 'border border-neutral-200 bg-white text-neutral-700 hover:border-neutral-300 hover:bg-neutral-50',
    'danger' => 'border border-red-200 bg-white text-red-600 hover:bg-red-50',
    default => 'bg-brand-600 text-white hover:bg-brand-700',
};
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
