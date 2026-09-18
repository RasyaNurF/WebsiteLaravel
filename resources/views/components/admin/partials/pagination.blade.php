@if ($paginator->hasPages())
    <div class="flex flex-col items-center justify-between gap-3 border-t border-neutral-200 px-4 py-3 sm:flex-row sm:px-5">
        <p class="text-xs text-neutral-500">
            Menampilkan <span class="font-semibold text-neutral-700">{{ $paginator->firstItem() }}</span>–<span class="font-semibold text-neutral-700">{{ $paginator->lastItem() }}</span>
            dari <span class="font-semibold text-neutral-700">{{ $paginator->total() }}</span> data
        </p>
        <nav class="flex items-center gap-1" aria-label="Navigasi halaman">
            @if ($paginator->onFirstPage())
                <span class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-300"><x-admin.icon name="chevron-left" class="h-4 w-4" /></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"
                    class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-600 transition hover:bg-neutral-100"><x-admin.icon name="chevron-left" class="h-4 w-4" /></a>
            @endif

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="flex h-8 min-w-8 items-center justify-center rounded-md bg-neutral-900 px-2 text-xs font-semibold text-white" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-xs font-medium text-neutral-600 transition hover:bg-neutral-100">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"
                    class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-600 transition hover:bg-neutral-100"><x-admin.icon name="chevron-right" class="h-4 w-4" /></a>
            @else
                <span class="flex h-8 w-8 items-center justify-center rounded-md text-neutral-300"><x-admin.icon name="chevron-right" class="h-4 w-4" /></span>
            @endif
        </nav>
    </div>
@endif
