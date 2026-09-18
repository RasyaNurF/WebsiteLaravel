{{-- Tombol aksi tabel: lihat, ubah, hapus. --}}
@props(['view' => null, 'edit' => null, 'delete' => null, 'deleteConfirm' => 'Hapus data ini? Tindakan tidak dapat dibatalkan.'])

<div class="flex items-center justify-end gap-0.5">
    @if ($view)
        <a href="{{ $view }}" class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-500 transition hover:bg-neutral-100 hover:text-neutral-900" title="Lihat" aria-label="Lihat">
            <x-admin.icon name="search" class="h-4 w-4" />
        </a>
    @endif
    @if ($edit)
        <a href="{{ $edit }}" class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-500 transition hover:bg-neutral-100 hover:text-neutral-900" title="Ubah" aria-label="Ubah">
            <x-admin.icon name="edit" class="h-4 w-4" />
        </a>
    @endif
    @if ($delete)
        <form method="post" action="{{ $delete }}" data-confirm="{{ $deleteConfirm }}">
            @csrf
            @method('delete')
            <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-400 transition hover:bg-red-50 hover:text-red-600" title="Hapus" aria-label="Hapus">
                <x-admin.icon name="trash" class="h-4 w-4" />
            </button>
        </form>
    @endif
</div>
