@php($avatarUrl = $user?->avatarUrl())

@if ($avatarUrl)
    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" {{ $attributes->merge(['class' => 'rounded-full object-cover']) }}>
@else
    <span {{ $attributes->merge(['class' => 'flex items-center justify-center rounded-full bg-navy-800 text-xs font-bold text-white']) }}>{{ $user?->initials() ?? '?' }}</span>
@endif
