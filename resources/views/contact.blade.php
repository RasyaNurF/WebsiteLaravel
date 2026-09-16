@extends('layouts.site')

@section('title', 'Kontak — Nusakode')
@section('meta-description', 'Hubungi PT Nusakode Teknologi untuk diskusi kebutuhan aplikasi, sistem informasi, dan infrastruktur TI perusahaan Anda.')

@section('content')
@php
$faqs = [
    ['q' => 'Berapa biaya pengerjaan sebuah proyek?', 'a' => 'Tergantung lingkupnya. Setelah diskusi awal, Anda menerima penawaran tertulis dengan biaya tetap — tidak ada tagihan kejutan di tengah jalan. Sebagai gambaran, aplikasi operasional skala menengah umumnya berada di kisaran puluhan hingga ratusan juta rupiah.'],
    ['q' => 'Berapa lama waktu pengerjaannya?', 'a' => 'Modul tunggal biasanya 4–8 minggu, sedangkan sistem terintegrasi 3–6 bulan. Jadwal rinci per modul tercantum dalam dokumen penawaran dan didemokan berkala.'],
    ['q' => 'Apakah kode sumber menjadi milik kami?', 'a' => 'Ya, sepenuhnya. Kode sumber, dokumentasi, kredensial, dan aset lainnya diserahterimakan 100% kepada Anda, berikut pelatihan untuk operator dan tim internal.'],
    ['q' => 'Bagaimana dukungan setelah serah terima?', 'a' => 'Anda dapat melanjutkan dengan kontrak pemeliharaan ber-SLA: waktu respons terukur, pemantauan uptime, pembaruan keamanan rutin, dan laporan berkala. Masa garansi perbaikan bug berlaku untuk setiap serah terima modul.'],
];
@endphp

{{-- ============ KEPALA HALAMAN ============ --}}
<section class="bg-navy-950 py-16 text-white sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-400">Kontak</p>
        <h1 class="mt-3 max-w-2xl text-3xl font-extrabold tracking-tight text-balance sm:text-5xl">Mari diskusikan kebutuhan Anda</h1>
        <p class="mt-4 max-w-xl leading-relaxed text-neutral-300">Diskusi awal 30 menit — gratis, tanpa kewajiban. Setelah itu Anda menerima penawaran tertulis: lingkup, jadwal, dan biaya tetap.</p>
    </div>
</section>

{{-- ============ INFO KONTAK ============ --}}
<section class="py-16 sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-14 px-4 sm:px-6 lg:grid-cols-2">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-navy-950">Saluran resmi</h2>
            <dl class="mt-6 divide-y divide-neutral-200 border-y border-neutral-200 text-[15px]">
                <div class="grid grid-cols-[120px_1fr] gap-4 py-5">
                    <dt class="font-bold text-navy-950">Email</dt>
                    <dd><a href="mailto:halo@nusakode.id?subject=Diskusi%20Kebutuhan%20TI" class="font-semibold text-navy-700 hover:underline">halo@nusakode.id</a></dd>
                </div>
                <div class="grid grid-cols-[120px_1fr] gap-4 py-5">
                    <dt class="font-bold text-navy-950">Telepon</dt>
                    <dd><a href="tel:+622150001234" class="font-semibold text-navy-700 hover:underline">+62 21 5000 1234</a></dd>
                </div>
                <div class="grid grid-cols-[120px_1fr] gap-4 py-5">
                    <dt class="font-bold text-navy-950">Jam kerja</dt>
                    <dd>Senin–Jumat, 09.00–18.00 WIB</dd>
                </div>
                <div class="grid grid-cols-[120px_1fr] gap-4 py-5">
                    <dt class="font-bold text-navy-950">Respons</dt>
                    <dd>Setiap pesan dibalas maksimal 1×24 jam kerja.</dd>
                </div>
            </dl>

        </div>

        <div>
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-extrabold tracking-tight text-navy-950">Chat dengan admin</h2>
                <p class="inline-flex items-center gap-1.5 text-xs font-semibold text-neutral-500">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-500 opacity-60"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-600"></span>
                    </span>
                    ONLINE
                </p>
            </div>
            <p class="mt-3 max-w-md text-[15px] leading-relaxed text-neutral-500">Sapa admin langsung di sini. Pesan Anda tersimpan dan dibalas maksimal 1&times;24 jam kerja.</p>

            <div class="mt-6 border border-neutral-200">
                <div id="chat-messages" class="h-80 space-y-4 overflow-y-auto bg-neutral-50 p-5" aria-live="polite">
                    @forelse ($messages as $message)
                        @if ($message->isGuest())
                            <div class="flex justify-end">
                                <div class="max-w-[80%] bg-navy-800 px-4 py-2.5 text-sm leading-relaxed text-white">
                                    <p>{{ $message->body }}</p>
                                    <p class="mt-1 text-right text-[11px] text-neutral-300">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start">
                                <div class="max-w-[80%] bg-white px-4 py-2.5 text-sm leading-relaxed ring-1 ring-neutral-200">
                                    <p class="text-[11px] font-bold text-navy-700">Admin Nusakode @if ($message->is_auto) <span class="font-medium text-neutral-400">(otomatis)</span> @endif</p>
                                    <p class="mt-0.5">{{ $message->body }}</p>
                                    <p class="mt-1 text-[11px] text-neutral-400">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div id="chat-empty" class="flex h-full items-center justify-center text-center">
                            <p class="max-w-60 text-sm text-neutral-400">Belum ada pesan. Mulai percakapan di bawah — admin siap membantu.</p>
                        </div>
                    @endforelse
                </div>

                <form id="chat-form" action="{{ route('kontak.chat') }}" method="post" class="border-t border-neutral-200 bg-white p-4">
                    @csrf
                    <div id="chat-identity" class="mb-3 grid gap-2 sm:grid-cols-2 {{ $messages->isNotEmpty() ? 'hidden' : '' }}">
                        <div>
                            <label for="chat-name" class="sr-only">Nama Anda</label>
                            <input id="chat-name" name="name" type="text" maxlength="100" autocomplete="name" placeholder="Nama Anda" class="w-full border border-neutral-300 px-3.5 py-2.5 text-sm focus:border-navy-700 focus:outline-none" value="{{ old('name') }}">
                        </div>
                        <div>
                            <label for="chat-email" class="sr-only">Email (opsional)</label>
                            <input id="chat-email" name="email" type="email" maxlength="255" autocomplete="email" placeholder="Email (opsional)" class="w-full border border-neutral-300 px-3.5 py-2.5 text-sm focus:border-navy-700 focus:outline-none" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <label for="chat-body" class="sr-only">Tulis pesan</label>
                        <input id="chat-body" name="body" type="text" maxlength="2000" required autocomplete="off" placeholder="Tulis pesan untuk admin…" class="w-full border border-neutral-300 px-3.5 py-2.5 text-sm focus:border-navy-700 focus:outline-none">
                        <button type="submit" class="shrink-0 bg-navy-800 px-5 text-sm font-bold text-white transition hover:bg-navy-900 disabled:cursor-wait disabled:opacity-60">
                            Kirim
                        </button>
                    </div>
                    <p id="chat-error" class="mt-2 hidden text-xs font-medium text-red-700" role="alert"></p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ============ FAQ ============ --}}
<section class="border-t border-neutral-100 bg-neutral-50/60 py-16 sm:py-20">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Sering ditanyakan</p>
        <h2 class="mt-3 text-2xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-3xl">Sebelum Anda menghubungi kami</h2>

        <div class="mt-8 divide-y divide-neutral-200 border-y border-neutral-200 bg-white">
            @foreach ($faqs as $faq)
                <details class="group px-6 py-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-[15px] font-bold text-navy-950 [&::-webkit-details-marker]:hidden">
                        {{ $faq['q'] }}
                        <svg class="h-4 w-4 shrink-0 text-neutral-400 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-neutral-500">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endsection
