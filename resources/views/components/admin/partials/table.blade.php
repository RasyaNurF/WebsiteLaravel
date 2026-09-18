{{-- Tabel responsif: scroll horizontal di layar kecil, kolom aksi rata kanan.
     Slot: $head (baris <th>), $slot (baris <tr>). --}}
<div class="overflow-x-auto">
    <table class="w-full min-w-[720px] border-collapse text-left text-[13px]">
        <thead>
            <tr class="border-b border-neutral-200 bg-neutral-50/50 text-[11px] font-bold uppercase tracking-[0.08em] text-neutral-500">
                {{ $head }}
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
