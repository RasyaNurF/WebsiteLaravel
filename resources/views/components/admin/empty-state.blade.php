<div class="flex flex-col items-center justify-center px-6 py-16 text-center">
    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-neutral-100 text-neutral-400">
        <x-admin.icon :name="$icon" class="h-5 w-5" />
    </span>
    <p class="mt-4 text-sm font-semibold text-neutral-900">{{ $title }}</p>
    @if ($description)
        <p class="mt-1 max-w-sm text-[13px] leading-relaxed text-neutral-500">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
