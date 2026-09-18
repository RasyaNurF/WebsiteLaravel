{{-- Unggah berkas non-gambar. Menyimpan path relatif di input hidden `{name}`,
     dan berkas pada input `{name}_file`. Bila tidak ada berkas baru, path lama dipertahankan. --}}
@props(['name', 'value' => null, 'label', 'hint' => null, 'accept' => null, 'required' => false])

@php
$inputId = $name.'_file';
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $inputId }}" class="block text-[13px] font-semibold text-neutral-800">
        {{ $label }}
        @if ($required)<span class="text-red-500" aria-hidden="true">*</span>@endif
    </label>
    @if ($hint)
        <p class="mt-0.5 text-xs text-neutral-500">{{ $hint }}</p>
    @endif

    <input type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}">

    <div class="mt-2 space-y-2">
        @if ($value)
            <p class="flex items-center gap-2 text-[13px] text-neutral-600">
                <x-admin.icon name="article" class="h-4 w-4 text-neutral-400" />
                <a href="{{\Illuminate\Support\Facades\Storage::disk('public')->url($value)}}" target="_blank" rel="noopener" class="font-semibold text-brand-700 hover:underline">Lihat berkas saat ini</a>
                <label class="inline-flex cursor-pointer items-center gap-1.5 text-neutral-500 hover:text-red-600">
                    <input type="checkbox" name="{{ $name }}_remove" value="1" class="h-3.5 w-3.5 accent-red-600">
                    Hapus
                </label>
            </p>
        @endif
        <input type="file" name="{{ $name }}_file" id="{{ $inputId }}" @if($accept) accept="{{ $accept }}" @endif
            class="block h-10 w-full rounded-md border border-neutral-200 px-3 py-2 text-sm text-neutral-900 outline-none transition file:mr-3 file:rounded file:border-0 file:bg-neutral-100 file:px-3 file:py-1.5 file:text-[13px] file:font-semibold file:text-neutral-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
    </div>

    @error($name)
        <p class="mt-1.5 flex items-start gap-1 text-xs font-medium text-red-600">
            <x-admin.icon name="alert" class="mt-px h-3.5 w-3.5 shrink-0" /> {{ $message }}
        </p>
    @enderror
    @error($name.'_file')
        <p class="mt-1.5 flex items-start gap-1 text-xs font-medium text-red-600">
            <x-admin.icon name="alert" class="mt-px h-3.5 w-3.5 shrink-0" /> {{ $message }}
        </p>
    @enderror
</div>
