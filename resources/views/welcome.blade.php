@extends('layouts.site')

@section('content')
@php
$clients = [
    ['file' => 'googlecloud', 'name' => 'Google Cloud', 'hover' => 'hover:text-[#4285F4]'],
    ['file' => 'github', 'name' => 'GitHub', 'hover' => 'hover:text-[#181717]'],
    ['file' => 'cloudflare', 'name' => 'Cloudflare', 'hover' => 'hover:text-[#F38020]'],
    ['file' => 'stripe', 'name' => 'Stripe', 'hover' => 'hover:text-[#635BFF]'],
    ['file' => 'vercel', 'name' => 'Vercel', 'hover' => 'hover:text-black'],
    ['file' => 'atlassian', 'name' => 'Atlassian', 'hover' => 'hover:text-[#0052CC]'],
    ['file' => 'docker', 'name' => 'Docker', 'hover' => 'hover:text-[#2496ED]'],
    ['file' => 'kubernetes', 'name' => 'Kubernetes', 'hover' => 'hover:text-[#326CE5]'],
    ['file' => 'gitlab', 'name' => 'GitLab', 'hover' => 'hover:text-[#FC6D26]'],
    ['file' => 'mongodb', 'name' => 'MongoDB', 'hover' => 'hover:text-[#47A248]'],
    ['file' => 'postgresql', 'name' => 'PostgreSQL', 'hover' => 'hover:text-[#4169E1]'],
    ['file' => 'laravel', 'name' => 'Laravel', 'hover' => 'hover:text-[#FF2D20]'],
    ['file' => 'php', 'name' => 'PHP', 'hover' => 'hover:text-[#777BB4]'],
    ['file' => 'python', 'name' => 'Python', 'hover' => 'hover:text-[#3776AB]'],
];

$services = [
    ['no' => '01', 'title' => 'Pengembangan Web & Aplikasi', 'desc' => 'Kami membangun website, web application, dashboard, dan platform digital sesuai kebutuhan bisnis Anda.', 'tags' => ['Laravel', 'Vue', 'React', 'MySQL'], 'img' => 'img/work-1.jpg', 'alt' => 'Dashboard aplikasi web di layar laptop'],
    ['no' => '02', 'title' => 'Sistem Informasi Bisnis', 'desc' => 'Sistem internal yang membantu perusahaan mengelola proses kerja secara lebih terstruktur, mulai dari keuangan, inventaris, SDM, hingga laporan.', 'tags' => ['Keuangan', 'Inventaris', 'SDM', 'Laporan'], 'img' => 'img/work-3.jpg', 'alt' => 'Sistem informasi bisnis di layar tablet'],
    ['no' => '03', 'title' => 'Integrasi API & Sistem', 'desc' => 'Menghubungkan aplikasi, payment gateway, layanan pihak ketiga, dan sistem internal agar data dapat berjalan otomatis dan real-time.', 'tags' => ['API', 'Payment Gateway', 'Database'], 'diagram' => true],
    ['no' => '04', 'title' => 'Aplikasi Mobile', 'desc' => 'Aplikasi Android dan iOS untuk layanan pelanggan, operasional, maupun kebutuhan bisnis khusus.', 'tags' => ['Android', 'iOS', 'Cross-Platform'], 'img' => 'img/work-2.jpg', 'alt' => 'Aplikasi mobile di layar ponsel'],
    ['no' => '05', 'title' => 'UI/UX & Product Design', 'desc' => 'Merancang antarmuka dan pengalaman pengguna yang sederhana, konsisten, dan mudah digunakan.', 'tags' => ['UI Design', 'UX Research', 'Prototyping'], 'img' => 'img/work-4.jpg', 'alt' => 'Desain antarmuka dan pengalaman pengguna'],
    ['no' => '06', 'title' => 'Maintenance & Pengembangan', 'desc' => 'Pemeliharaan sistem, peningkatan fitur, monitoring, perbaikan bug, dan dukungan teknis berkelanjutan.', 'tags' => ['Monitoring', 'Bug Fix', 'SLA'], 'img' => 'img/hero.jpg', 'alt' => 'Pemeliharaan dan monitoring sistem'],
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
    ['img' => 'img/work-1.jpg', 'tag' => 'Perbankan', 'title' => 'Dashboard Keuangan Internal'],
    ['img' => 'img/work-2.jpg', 'tag' => 'Distribusi', 'title' => 'Portal Pelaporan Penjualan'],
    ['img' => 'img/work-3.jpg', 'tag' => 'Pendidikan', 'title' => 'Sistem Penerimaan Peserta Didik'],
    ['img' => 'img/work-4.jpg', 'tag' => 'Logistik', 'title' => 'Integrasi Sistem Pergudangan'],
    ['img' => 'img/about.jpg', 'tag' => 'Kesehatan', 'title' => 'Rekam Medis Elektronik'],
    ['img' => 'img/hero.jpg', 'tag' => 'Manufaktur', 'title' => 'Monitoring Lini Produksi'],
    ['img' => 'img/work-2.jpg', 'tag' => 'Pemerintahan', 'title' => 'Portal Layanan Publik'],
    ['img' => 'img/work-1.jpg', 'tag' => 'Ritel', 'title' => 'Katalog & Pemesanan Multi-Cabang'],
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
        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-52 sm:px-6 sm:pb-28 sm:pt-64">
            <div class="max-w-2xl">
                <p class="flex items-center gap-3 text-[11px] font-bold uppercase tracking-[0.28em] text-neutral-300"><span class="h-0.5 w-10 bg-brand-500" aria-hidden="true"></span>Teknologi &amp; Solusi Digital</p>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-balance sm:text-6xl">
                    Teknologi yang merapikan cara bisnis Anda <span class="text-brand-400">bekerja</span>
                </h1>
                <p class="mt-5 max-w-xl text-base leading-relaxed text-neutral-200 sm:text-lg">
                    Aplikasi, sistem, dan infrastruktur TI untuk perusahaan — lingkup tertulis, biaya tetap, serah terima penuh.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('kontak') }}" class="group inline-flex items-center gap-2 rounded-full bg-brand-600 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-brand-500">
                        Diskusikan Kebutuhan Anda
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="#portofolio" class="group inline-flex items-center gap-2 px-2 py-3.5 text-sm font-bold text-white">
                        Lihat hasil kerja kami
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
                <dl class="mt-12 flex divide-x divide-white/15 pt-8">
                    <div class="pr-8 sm:pr-12"><dt class="sr-only">Pengalaman</dt><dd class="text-2xl font-extrabold">10+</dd><dd class="mt-1 text-xs font-medium text-neutral-300">Tahun pengalaman</dd></div>
                    <div class="px-8 sm:px-12"><dt class="sr-only">Proyek</dt><dd class="text-2xl font-extrabold">120+</dd><dd class="mt-1 text-xs font-medium text-neutral-300">Proyek selesai</dd></div>
                    <div class="pl-8 sm:pl-12"><dt class="sr-only">Retensi</dt><dd class="text-2xl font-extrabold">98%</dd><dd class="mt-1 text-xs font-medium text-neutral-300">Klien melanjutkan</dd></div>
                </dl>
            </div>
        </div>
    </section>

    {{-- ============ KLIEN ============ --}}
    <section class="border-y border-neutral-100 bg-neutral-50/60 py-10" aria-label="Klien yang bekerja sama">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="overflow-hidden">
                <div class="flex w-max animate-marquee items-center">
                    @foreach ([false, true] as $duplicate)
                        <div class="flex items-center gap-14 pr-14 text-neutral-400" @if ($duplicate) aria-hidden="true" @endif>
                            @foreach ($clients as $c)
                                @php($svg = file_get_contents(public_path("img/brands/{$c['file']}.svg")))
                                <span class="inline-flex items-center gap-2.5 transition {{ $c['hover'] }}" title="{{ $c['name'] }}">
                                    <span class="block h-7 w-7 shrink-0 [&>svg]:h-full [&>svg]:w-full">{!! $svg !!}</span>
                                    <span class="whitespace-nowrap text-sm font-bold">{{ $c['name'] }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ LAYANAN ============ --}}
    <section id="layanan" class="scroll-mt-24 overflow-hidden py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-8 lg:grid-cols-2 lg:items-end">
                <div>
                    <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.22em] text-neutral-400"><span class="h-px w-8 bg-neutral-300" aria-hidden="true"></span>Layanan</p>
                    <h2 class="mt-4 max-w-xl text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Solusi digital yang dibangun untuk bisnis.</h2>
                    <p class="mt-4 max-w-xl text-[15px] leading-relaxed text-neutral-500">Kami merancang dan membangun sistem digital yang disesuaikan dengan proses bisnis, kebutuhan pengguna, dan tujuan perusahaan Anda.</p>
                </div>
                <div class="lg:max-w-sm lg:justify-self-end">
                    <p class="text-[13px] leading-relaxed text-neutral-500">Dari pengembangan aplikasi hingga integrasi sistem, setiap solusi kami fokus pada kualitas, performa, dan pengalaman pengguna yang optimal.</p>
                    <a href="{{ url('/#tentang') }}" class="group mt-4 inline-flex items-center gap-3 text-[13px] font-bold text-navy-950">
                        <span class="h-px w-8 bg-neutral-300 transition group-hover:w-12 group-hover:bg-navy-800" aria-hidden="true"></span>
                        Mengapa memilih kami
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-14" data-no-reveal>
            @foreach ($services as $s)
                <div data-service-item class="grid items-stretch lg:grid-cols-2">
                    <div class="flex items-center {{ $loop->even ? 'lg:order-2' : '' }}">
                        <div class="w-full px-4 py-12 sm:px-6 lg:py-20 {{ $loop->even ? 'lg:pl-12 lg:pr-[max(1.5rem,calc((100vw-80rem)/2+1.5rem))]' : 'lg:pl-[max(1.5rem,calc((100vw-80rem)/2+1.5rem))] lg:pr-12' }}">
                            <p class="flex items-center gap-3 text-sm font-extrabold tabular-nums text-neutral-400"><span>{{ $s['no'] }}</span><span class="h-px w-10 bg-neutral-300" aria-hidden="true"></span></p>
                            <h3 class="mt-4 text-xl font-extrabold tracking-tight text-navy-950 sm:text-2xl">{{ $s['title'] }}</h3>
                            <p class="mt-3 max-w-md text-[15px] leading-relaxed text-neutral-500">{{ $s['desc'] }}</p>
                            <p class="mt-4 text-[13px] font-medium text-neutral-400">{!! implode(' &nbsp;·&nbsp; ', array_map('e', $s['tags'])) !!}</p>
                            <a href="{{ route('kontak') }}" class="group mt-8 inline-flex items-center gap-2 text-[13px] font-bold text-navy-950">
                                Lihat detail layanan
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="group relative min-h-72 overflow-hidden lg:min-h-[420px]">
                        @if (!empty($s['diagram']))
                            <div class="absolute inset-0 flex items-center justify-center overflow-hidden bg-navy-950 p-6 sm:p-10">
                                <div class="pointer-events-none absolute -top-24 left-1/2 h-64 w-[36rem] -translate-x-1/2 rounded-full bg-navy-600/40 blur-3xl" aria-hidden="true"></div>
                                <div class="relative flex items-center gap-3 sm:gap-5">
                                    <span class="hidden flex-col items-center gap-2 rounded-xl bg-white/5 px-4 py-5 text-center ring-1 ring-white/10 sm:flex">
                                        <svg class="h-6 w-6 text-brand-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2.5" y="5" width="19" height="14" rx="2.5"/><path d="M2.5 10h19M6 15h4"/></svg>
                                        <span class="text-[11px] font-semibold leading-tight text-neutral-300">Payment<br>Gateway</span>
                                    </span>
                                    <span class="hidden h-px w-6 bg-gradient-to-r from-transparent to-brand-500/70 sm:block" aria-hidden="true"></span>
                                    <span class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 text-2xl font-extrabold text-white ring-1 ring-brand-500/50 transition duration-500 group-hover:ring-brand-400" aria-hidden="true">&lt;/&gt;</span>
                                    <span class="hidden h-px w-6 bg-gradient-to-l from-transparent to-brand-500/70 sm:block" aria-hidden="true"></span>
                                    <span class="flex flex-col gap-2.5">
                                        @foreach ([['API', 'M12 3v3m0 12v3M5.6 5.6l2.1 2.1m8.6 8.6 2.1 2.1m0-12.8-2.1 2.1M7.7 16.3l-2.1 2.1'], ['Database', 'M12 3c4.4 0 8 1.1 8 2.5S16.4 8 12 8 4 6.9 4 5.5 7.6 3 12 3Zm-8 2.5V18c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5V5.5'], ['Third Party', 'M10 14a5 5 0 0 0 7 0l3-3a5 5 0 0 0-7-7l-1.5 1.5M14 10a5 5 0 0 0-7 0l-3 3a5 5 0 0 0 7 7l1.5-1.5']] as $node)
                                            <span class="flex items-center gap-2.5 rounded-xl bg-white/5 px-4 py-2.5 text-[13px] font-semibold text-neutral-200 ring-1 ring-white/10 transition duration-500 group-hover:ring-white/25">
                                                <svg class="h-5 w-5 shrink-0 text-brand-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $node[1] }}"/></svg>
                                                {{ $node[0] }}
                                            </span>
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        @else
                            <img src="{{ asset($s['img']) }}" alt="{{ $s['alt'] }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]" loading="lazy">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ SOLUSI INDUSTRI ============ --}}
    <section id="solusi" class="scroll-mt-24 border-t border-white/5 bg-navy-950 py-20 text-white sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-400">Solusi per industri</p>
                    <h2 class="mt-4 max-w-lg text-3xl font-extrabold tracking-tight text-balance sm:text-4xl">Disesuaikan dengan cara kerja setiap sektor</h2>
                </div>
                <p class="max-w-sm text-[15px] leading-relaxed text-neutral-400">Satu tim, pola yang sama: pahami prosesnya dulu, bangun sistemnya kemudian.</p>
            </div>

            <div class="mt-14 divide-y divide-white/10 border-t border-white/10">
                @foreach ($industries as $ind)
                    <div class="group grid gap-6 py-8 lg:grid-cols-12 lg:items-center lg:gap-8">
                        <div class="lg:col-span-1">
                            <span class="text-sm font-extrabold tabular-nums text-white/25 transition group-hover:text-brand-400">0{{ $loop->iteration }}</span>
                        </div>
                        <div class="lg:col-span-4">
                            <h3 class="text-xl font-bold tracking-tight sm:text-2xl">{{ $ind['name'] }}</h3>
                            <p class="mt-2 text-[13px] font-semibold text-neutral-500">{{ implode(' · ', $ind['tags']) }}</p>
                        </div>
                        <div class="lg:col-span-6">
                            <p class="text-[15px] leading-relaxed text-neutral-400">{{ $ind['desc'] }}</p>
                        </div>
                        <div class="lg:col-span-1 lg:justify-self-end">
                            <a href="{{ route('kontak') }}" aria-label="Konsultasi untuk {{ $ind['name'] }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-neutral-400 transition group-hover:border-brand-500 group-hover:text-brand-400">
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
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
                    <li class="group transition">
                        <p class="text-5xl font-extrabold tracking-tight text-navy-100 transition group-hover:text-brand-500">{{ $st['no'] }}</p>
                        <h3 class="mt-4 text-base font-bold text-navy-950 transition group-hover:text-navy-600">{{ $st['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-neutral-500 transition group-hover:text-neutral-700">{{ $st['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ============ PORTOFOLIO ============ --}}
    <section id="portofolio" class="scroll-mt-24 overflow-hidden bg-neutral-50/60 py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Portofolio</p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950 sm:text-4xl">Pekerjaan yang sudah berjalan produksi</h2>
                </div>
                <a href="{{ route('kontak') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-navy-800">
                    Diskusikan proyek serupa
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        </div>

        <div class="mt-14 space-y-6" data-no-reveal>
            @foreach (array_chunk($works, 4) as $rowIndex => $row)
                <div class="group overflow-hidden">
                    <div class="flex w-max {{ $rowIndex === 0 ? 'animate-marquee-left' : 'animate-marquee-right' }}">
                        @foreach ([false, true] as $duplicate)
                            <div class="flex shrink-0 gap-6 pr-6" @if ($duplicate) aria-hidden="true" @endif>
                                @foreach ($row as $w)
                                    <a href="{{ route('kontak') }}" class="group/card relative block w-[320px] shrink-0 overflow-hidden rounded-2xl sm:w-[420px]">
                                        <img src="{{ asset($w['img']) }}" alt="{{ $w['title'] }}" class="h-72 w-full object-cover transition duration-700 group-hover/card:scale-[1.06] sm:h-80" loading="lazy">
                                        <span class="absolute inset-0 bg-gradient-to-t from-navy-950/90 via-navy-950/25 to-transparent" aria-hidden="true"></span>
                                        <span class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                                            <span class="block text-[11px] font-bold uppercase tracking-[0.2em] text-brand-400">{{ $w['tag'] }}</span>
                                            <span class="mt-1.5 block text-lg font-bold leading-snug text-white sm:text-xl">{{ $w['title'] }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
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
                <a href="{{ route('kontak') }}" class="rounded-full bg-brand-600 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-brand-500">Hubungi Kami</a>
                <a href="tel:+622150001234" class="rounded-full border border-white/30 px-8 py-3.5 text-sm font-bold transition hover:border-white hover:bg-white/10">+62 21 5000 1234</a>
            </div>
        </div>
    </section>

@endsection
