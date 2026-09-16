@extends('layouts.site')

@section('content')
@php
$services = [
    ['no' => '01', 'title' => 'Pengembangan Aplikasi Web', 'desc' => 'Portal perusahaan, dashboard internal, dan aplikasi operasional yang dibangun mengikuti alur kerja Anda — bukan template generik.'],
    ['no' => '02', 'title' => 'Sistem Informasi & ERP', 'desc' => 'Keuangan, SDM, inventaris, dan pelaporan dalam satu sistem terintegrasi dengan hak akses berlapis dan jejak audit.'],
    ['no' => '03', 'title' => 'Integrasi Sistem & API', 'desc' => 'Menghubungkan aplikasi yang sudah berjalan — payment gateway, akuntansi, logistik — agar data mengalir tanpa entri ganda.'],
    ['no' => '04', 'title' => 'Infrastruktur & Cloud', 'desc' => 'Perancangan server, migrasi cloud, pencadangan terjadwal, dan dokumentasi topologi yang diserahterimakan penuh.'],
    ['no' => '05', 'title' => 'Keamanan Informasi', 'desc' => 'Pengujian penetrasi aplikasi web dan jaringan, hardening server, serta rekomendasi perbaikan berprioritas risiko.'],
    ['no' => '06', 'title' => 'Pemeliharaan & SLA', 'desc' => 'Kontrak dukungan dengan waktu respons terukur, pemantauan uptime, pembaruan keamanan rutin, dan laporan berkala.'],
];

$industries = [
    ['name' => 'Keuangan & Perbankan', 'desc' => 'Portal anggota, pengajuan pembiayaan, dan pelaporan yang dapat diaudit — menggantikan pencatatan manual yang tersebar.', 'tags' => ['Portal Anggota', 'Pelaporan', 'Audit Trail']],
    ['name' => 'Ritel & Distribusi', 'desc' => 'Katalog, pemesanan antar cabang, dan integrasi stok sehingga data penjualan dan persediaan selalu selaras.', 'tags' => ['Stok Multi-Cabang', 'Pemesanan', 'Integrasi POS']],
    ['name' => 'Pendidikan', 'desc' => 'Penerimaan peserta didik, akademik, dan komunikasi kampus dalam satu platform yang mudah dioperasikan staf non-teknis.', 'tags' => ['PPDB', 'Akademik', 'Portal Orang Tua']],
    ['name' => 'Pemerintahan & BUMN', 'desc' => 'Layanan berbasis web dengan memperhatikan standar keamanan dan kearsipan, berikut dokumen pendukung pengadaan.', 'tags' => ['Layanan Publik', 'Kearsipan', 'Dokumen Pengadaan']],
];

$steps = [
    ['no' => '01', 'title' => 'Penemuan & Analisis', 'desc' => 'Kami petakan proses bisnis, kendala, dan target terukur. Keluaran: dokumen lingkup, jadwal, dan biaya tetap.'],
    ['no' => '02', 'title' => 'Perancangan', 'desc' => 'Alur sistem, struktur data, dan tampilan disepakati di awal. Tidak ada pengerjaan tanpa persetujuan tertulis.'],
    ['no' => '03', 'title' => 'Pembangunan Bertahap', 'desc' => 'Pekerjaan dibagi per modul dan didemokan berkala. Anda melihat progres nyata, bukan laporan di atas kertas.'],
    ['no' => '04', 'title' => 'Serah Terima & Dukungan', 'desc' => 'Kode sumber, dokumentasi, dan akses sepenuhnya milik Anda — dilanjutkan opsi kontrak pemeliharaan ber-SLA.'],
];

$works = [
    ['img' => 'img/work-1.jpg', 'tag' => 'Perbankan', 'title' => 'Dashboard Keuangan Internal', 'result' => 'Waktu penyusunan laporan bulanan turun dari 5 hari menjadi 1 hari.'],
    ['img' => 'img/work-2.jpg', 'tag' => 'Distribusi', 'title' => 'Portal Pelaporan Penjualan', 'result' => '42 cabang melaporkan penjualan harian dalam satu format standar.'],
    ['img' => 'img/work-3.jpg', 'tag' => 'Pendidikan', 'title' => 'Sistem Penerimaan Peserta Didik', 'result' => '12.000+ pendaftar diproses dalam satu periode tanpa antrean fisik.'],
    ['img' => 'img/work-4.jpg', 'tag' => 'Logistik', 'title' => 'Integrasi Sistem Pergudangan', 'result' => 'Selisih stok antar sistem turun di bawah 1% dalam tiga bulan.'],
];

$quotes = [
    ['text' => 'Lingkup pekerjaan disepakati di awal dan tidak berubah-ubah di tengah jalan. Setiap termin dikaitkan dengan hasil yang bisa kami uji sendiri.', 'name' => 'Rani Prameswari', 'role' => 'Head of Operations, Bank Arta', 'initials' => 'RP'],
    ['text' => 'Tim kami yang awalnya mencatat di spreadsheet sekarang bekerja dalam satu sistem. Laporan bulanan yang dulu seminggu, sekarang selesai sehari.', 'name' => 'Bayu Santoso', 'role' => 'Direktur, Sinar Niaga', 'initials' => 'BS'],
    ['text' => 'Dokumentasinya lengkap dan kode diserahterimakan penuh. Tim internal kami bisa melanjutkan pengembangan tanpa ketergantungan.', 'name' => 'Dr. Lestari Widodo', 'role' => 'Wakil Rektor, Universitas Cendana', 'initials' => 'LW'],
];

$insights = [
    ['cat' => 'Panduan', 'img' => 'img/work-3.jpg', 'title' => 'Menyusun Kerangka Acuan Kerja Proyek Software Agar Tidak Bengkak', 'date' => '11 September 2026'],
    ['cat' => 'Keamanan', 'img' => 'img/work-4.jpg', 'title' => 'Jadwal Pengujian Penetrasi yang Wajar untuk Aplikasi Perusahaan', 'date' => '9 September 2026'],
    ['cat' => 'Operasional', 'img' => 'img/work-2.jpg', 'title' => 'Checklist Serah Terima Aplikasi dari Vendor ke Tim Internal', 'date' => '5 September 2026'],
];
@endphp

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <img src="{{ asset('img/hero.jpg') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover" loading="eager" fetchpriority="high">
        <div class="absolute inset-0 bg-navy-950/70" aria-hidden="true" data-no-reveal></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28">
            <div class="max-w-2xl">
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-balance sm:text-6xl">
                    Teknologi yang merapikan cara bisnis Anda bekerja
                </h1>
                <p class="mt-5 max-w-xl text-base leading-relaxed text-neutral-200 sm:text-lg">
                    Aplikasi, sistem, dan infrastruktur TI untuk perusahaan — lingkup tertulis, biaya tetap, serah terima penuh.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('kontak') }}" class="rounded-full bg-brand-500 px-8 py-3.5 text-sm font-bold text-navy-950 transition hover:bg-brand-400">Diskusikan Kebutuhan Anda</a>
                    <a href="#portofolio" class="group inline-flex items-center gap-2 px-2 py-3.5 text-sm font-bold text-white">
                        Lihat hasil kerja kami
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
                <dl class="mt-12 flex gap-10 border-t border-white/15 pt-8 sm:gap-14">
                    <div><dt class="sr-only">Pengalaman</dt><dd class="text-2xl font-extrabold">10+</dd><dd class="mt-1 text-xs font-medium text-neutral-300">Tahun pengalaman</dd></div>
                    <div><dt class="sr-only">Proyek</dt><dd class="text-2xl font-extrabold">120+</dd><dd class="mt-1 text-xs font-medium text-neutral-300">Proyek selesai</dd></div>
                    <div><dt class="sr-only">Retensi</dt><dd class="text-2xl font-extrabold">98%</dd><dd class="mt-1 text-xs font-medium text-neutral-300">Klien melanjutkan</dd></div>
                </dl>
            </div>
        </div>
    </section>

    {{-- ============ KLIEN ============ --}}
    <section class="border-y border-neutral-100 bg-neutral-50/60 py-10" aria-label="Klien yang bekerja sama">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="overflow-hidden">
                <div class="flex w-max animate-marquee items-center text-neutral-400">
                    <div class="flex items-center gap-14 pr-14" aria-hidden="false">
                        <span class="text-sm font-extrabold tracking-wide">BANK ARTA</span>
                        <span class="text-sm font-bold">Sinar Niaga</span>
                        <span class="text-sm font-extrabold tracking-widest">KOPEPRIMA</span>
                        <span class="text-sm font-semibold">telkomda</span>
                        <span class="text-sm font-extrabold">GRUP ANDALAN</span>
                        <span class="text-sm font-bold">Univ. Cendana</span>
                        <span class="text-sm font-semibold">IDN Media</span>
                        <span class="text-sm font-extrabold tracking-wide">ADTEK</span>
                    </div>
                    <div class="flex items-center gap-14 pr-14" aria-hidden="true">
                        <span class="text-sm font-extrabold tracking-wide">BANK ARTA</span>
                        <span class="text-sm font-bold">Sinar Niaga</span>
                        <span class="text-sm font-extrabold tracking-widest">KOPEPRIMA</span>
                        <span class="text-sm font-semibold">telkomda</span>
                        <span class="text-sm font-extrabold">GRUP ANDALAN</span>
                        <span class="text-sm font-bold">Univ. Cendana</span>
                        <span class="text-sm font-semibold">IDN Media</span>
                        <span class="text-sm font-extrabold tracking-wide">ADTEK</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ LAYANAN ============ --}}
    <section id="layanan" class="scroll-mt-24 py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Layanan</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Enam pekerjaan yang kami kuasai</h2>
                <p class="mt-4 leading-relaxed text-neutral-500">Sengaja terbatas — agar setiap pekerjaan bisa dipertanggungjawabkan mutu, jadwal, dan biayanya.</p>
            </div>

            <div class="mt-12 divide-y divide-neutral-200 border-y border-neutral-200">
                @foreach ($services as $s)
                    <a href="{{ route('kontak') }}" class="group grid gap-2 py-7 transition hover:bg-neutral-50 sm:grid-cols-12 sm:items-baseline sm:gap-6 sm:px-4">
                        <span class="text-sm font-extrabold tabular-nums text-brand-600 sm:col-span-1">{{ $s['no'] }}</span>
                        <span class="text-xl font-bold tracking-tight text-navy-950 sm:col-span-4">{{ $s['title'] }}</span>
                        <span class="text-[15px] leading-relaxed text-neutral-500 sm:col-span-6">{{ $s['desc'] }}</span>
                        <span class="hidden justify-end sm:col-span-1 sm:flex">
                            <svg class="h-5 w-5 text-neutral-300 transition-all group-hover:translate-x-1 group-hover:text-navy-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ SOLUSI INDUSTRI ============ --}}
    <section id="solusi" class="scroll-mt-24 bg-navy-950 py-20 text-white sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-8 lg:grid-cols-12">
                <div class="lg:col-span-4">
                    <div class="lg:sticky lg:top-28">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-400">Solusi per industri</p>
                        <h2 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Disesuaikan dengan cara kerja setiap sektor</h2>
                        <p class="mt-4 leading-relaxed text-neutral-400">Satu tim, pola yang sama: pahami prosesnya dulu, bangun sistemnya kemudian.</p>
                        <a href="{{ route('kontak') }}" class="mt-8 inline-block rounded-full bg-brand-500 px-7 py-3 text-sm font-bold text-navy-950 transition hover:bg-brand-400">Tanya untuk industri Anda</a>
                    </div>
                </div>
                <div class="lg:col-span-8">
                    <div class="divide-y divide-white/10 border-y border-white/10">
                        @foreach ($industries as $ind)
                            <div class="grid gap-3 py-8 sm:grid-cols-2 sm:gap-6">
                                <h3 class="text-lg font-bold">{{ $ind['name'] }}</h3>
                                <div>
                                    <p class="text-[15px] leading-relaxed text-neutral-400">{{ $ind['desc'] }}</p>
                                    <p class="mt-3 text-[13px] font-semibold text-neutral-500">{{ implode(' · ', $ind['tags']) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CARA KERJA ============ --}}
    <section id="proses" class="scroll-mt-24 py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Cara kerja</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Tahapan yang bisa Anda audit</h2>
            </div>

            <ol class="mt-14 grid gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
                @foreach ($steps as $st)
                    <li>
                        <p class="text-5xl font-extrabold tracking-tight text-navy-100">{{ $st['no'] }}</p>
                        <h3 class="mt-4 text-base font-bold text-navy-950">{{ $st['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-neutral-500">{{ $st['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ============ PORTOFOLIO ============ --}}
    <section id="portofolio" class="scroll-mt-24 bg-neutral-50/60 py-20 sm:py-28">
        <div class="mx-auto max-w-7xl space-y-20 px-4 sm:px-6">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Portofolio</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Pekerjaan yang sudah berjalan produksi</h2>
            </div>

            @foreach ($works as $w)
                <article class="grid items-center gap-8 lg:grid-cols-2 lg:gap-16">
                    <div class="{{ $loop->odd ? 'lg:order-2' : '' }}">
                        <div class="overflow-hidden">
                            <img src="{{ asset($w['img']) }}" alt="{{ $w['title'] }}" class="h-64 w-full object-cover transition duration-700 group-hover:scale-[1.04] sm:h-80" loading="lazy">
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">{{ $w['tag'] }}</p>
                        <h3 class="mt-3 text-2xl font-extrabold tracking-tight text-navy-950 sm:text-3xl">{{ $w['title'] }}</h3>
                        <p class="mt-4 flex gap-2.5 text-[15px] leading-relaxed text-neutral-500">
                            <svg class="mt-1 h-4 w-4 shrink-0 text-navy-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                            {{ $w['result'] }}
                        </p>
                        <a href="{{ route('kontak') }}" class="group mt-6 inline-flex items-center gap-2 text-sm font-bold text-navy-800">
                            Diskusikan proyek serupa
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- ============ TENTANG ============ --}}
    <section id="tentang" class="scroll-mt-24 py-20 sm:py-28">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Tentang kami</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Bekerja seperti divisi internal Anda</h2>
                <p class="mt-5 leading-relaxed text-neutral-500">
                    PT Nusakode Teknologi berdiri di Jakarta pada 2015. Kami melayani perusahaan menengah hingga enterprise — sebagai pelaksana proyek sekaligus mitra pemeliharaan jangka panjang.
                </p>
                <ul class="mt-8 space-y-4">
                    @foreach (['Kontrak kerja tertulis: lingkup, jadwal, biaya, dan garansi tercantum jelas.', 'Tim tetap, bukan lepas: engineer yang mengerjakan proyek Anda adalah karyawan kami.', 'Serah terima penuh: kode sumber, dokumentasi, kredensial, dan pelatihan operator.'] as $point)
                        <li class="flex gap-3 text-[15px]">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-navy-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <img src="{{ asset('img/about.jpg') }}" alt="Rapat perencanaan proyek di kantor Nusakode" class="h-80 w-full object-cover sm:h-[460px]" loading="lazy">
        </div>
    </section>

    {{-- ============ TESTIMONI ============ --}}
    <section class="border-y border-neutral-100 bg-neutral-50/60 py-20 sm:py-28" aria-label="Testimoni klien">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Testimoni</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Kata mereka yang bekerja bersama kami</h2>
            </div>

            <div class="mt-12 overflow-hidden">
                <div class="flex w-max animate-marquee">
                    @foreach ([false, true] as $duplicate)
                        <div class="flex gap-14 pr-14" @if ($duplicate) aria-hidden="true" @endif>
                            @foreach ($quotes as $q)
                                <figure class="w-[300px] shrink-0 sm:w-[380px]">
                                    <span class="font-serif text-5xl leading-none text-brand-500" aria-hidden="true">&ldquo;</span>
                                    <blockquote class="-mt-2 text-[15px] leading-relaxed text-neutral-600">{{ $q['text'] }}</blockquote>
                                    <figcaption class="mt-6 flex items-center gap-3">
                                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-navy-800 text-sm font-bold text-white" aria-hidden="true">{{ $q['initials'] }}</span>
                                        <span>
                                            <span class="block text-sm font-bold text-navy-950">{{ $q['name'] }}</span>
                                            <span class="block text-xs text-neutral-500">{{ $q['role'] }}</span>
                                        </span>
                                    </figcaption>
                                </figure>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ INSIGHT ============ --}}
    <section id="insight" class="scroll-mt-24 py-20 sm:py-28">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Insight</p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Tulisan praktis dari tim kami</h2>
                </div>
                <a href="#insight" class="group inline-flex items-center gap-2 text-sm font-bold text-navy-800">
                    Semua artikel
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            <div class="mt-10 divide-y divide-neutral-200 border-y border-neutral-200">
                @foreach ($insights as $a)
                    <a href="#insight" class="group flex items-center gap-5 py-6 sm:gap-8 sm:px-2">
                        <span class="hidden w-36 shrink-0 overflow-hidden sm:block" aria-hidden="true"><img src="{{ asset($a['img']) }}" alt="" class="h-24 w-36 object-cover transition duration-500 group-hover:scale-[1.05]" loading="lazy"></span>
                        <span class="flex-1">
                            <span class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400">{{ $a['cat'] }} · {{ $a['date'] }}</span>
                            <span class="mt-1.5 block text-lg font-bold tracking-tight text-navy-950 transition group-hover:text-navy-600">{{ $a['title'] }}</span>
                        </span>
                        <svg class="h-5 w-5 shrink-0 text-neutral-300 transition-all group-hover:translate-x-1 group-hover:text-navy-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CTA KONTAK ============ --}}
    <section class="bg-navy-900 py-16 text-white">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-6 px-4 sm:px-6">
            <div class="max-w-xl">
                <h2 class="text-2xl font-extrabold tracking-tight text-balance sm:text-3xl">Punya kebutuhan teknologi untuk dibahas?</h2>
                <p class="mt-2 text-[15px] text-neutral-300">Ceritakan lewat halaman kontak — kami balas dengan penawaran tertulis.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('kontak') }}" class="rounded-full bg-brand-500 px-8 py-3.5 text-sm font-bold text-navy-950 transition hover:bg-brand-400">Hubungi Kami</a>
                <a href="tel:+622150001234" class="rounded-full border border-white/30 px-8 py-3.5 text-sm font-bold transition hover:border-white hover:bg-white/10">+62 21 5000 1234</a>
            </div>
        </div>
    </section>

@endsection
