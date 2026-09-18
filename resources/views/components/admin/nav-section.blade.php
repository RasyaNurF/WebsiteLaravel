@php($sectionActive = request()->routeIs(...$routes))

<p class="mb-1 mt-5 px-3 text-[10px] font-bold uppercase tracking-[0.16em] {{ $sectionActive ? 'text-brand-400/80' : 'text-white/30' }}">{{ $label }}</p>
