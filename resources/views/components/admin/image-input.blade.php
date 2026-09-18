{{-- Unggah gambar dengan pratinjau. Menyimpan path relatif di input hidden `{name}`,
     dan berkas pada input `{name}_file`. Bila tidak ada berkas baru, path lama dipertahankan. --}}
@php
$inputId = $name.'_file';
$currentUrl = $currentUrl();
$previewClasses = $previewClasses();
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

    <div class="mt-2 flex items-start gap-4" data-image-field>
        <div class="shrink-0">
            <img data-image-preview src="{{ $currentUrl }}" alt="Pratinjau {{ $label }}"
                class="{{ $previewClasses }} border border-neutral-200 bg-neutral-50 {{ $currentUrl ? '' : 'hidden' }}">
            <div data-image-placeholder class="{{ $previewClasses }} flex items-center justify-center border border-dashed border-neutral-300 bg-neutral-50 text-neutral-300 {{ $currentUrl ? 'hidden' : '' }}">
                <x-admin.icon name="image" class="h-5 w-5" />
            </div>
        </div>

        <div class="min-w-0 flex-1 space-y-2">
            <input type="file" name="{{ $name }}_file" id="{{ $inputId }}" accept="image/*"
                class="block h-10 w-full rounded-md border border-neutral-200 px-3 py-2 text-sm text-neutral-900 outline-none transition file:mr-3 file:rounded file:border-0 file:bg-neutral-100 file:px-3 file:py-1.5 file:text-[13px] file:font-semibold file:text-neutral-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
            <p class="text-xs text-neutral-400">
                PNG, JPG, WebP, atau SVG. Maks 5 MB.
                @if ($currentUrl)
                    · <label class="inline-flex cursor-pointer items-center gap-1.5 text-neutral-500 hover:text-red-600">
                        <input type="checkbox" name="{{ $name }}_remove" value="1" class="h-3.5 w-3.5 accent-red-600">
                        Hapus gambar
                    </label>
                @endif
            </p>
        </div>
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
