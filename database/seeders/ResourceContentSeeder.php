<?php

namespace Database\Seeders;

use App\Enums\PublishStatus;
use App\Enums\ResourceType;
use App\Models\Resource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ResourceContentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $now = Carbon::now();

        foreach ($this->resources($now) as $index => $data) {
            Resource::query()->updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                $data + [
                    'sort_order' => $index + 1,
                    'status' => PublishStatus::Published,
                    'cta_url' => null,
                ],
            );
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function resources(Carbon $now): array
    {
        return [
            ...$this->events($now),
            ...$this->goLive($now),
            ...$this->whitepapers($now),
            ...$this->ebooks($now),
            ...$this->news($now),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function events(Carbon $now): array
    {
        return [
            [
                'type' => ResourceType::Event,
                'title' => 'Tech Summit 2026: Transformasi Digital Enterprise',
                'excerpt' => 'Konferensi tahunan tentang transformasi digital untuk perusahaan enterprise di Indonesia.',
                'body' => "Tech Summit 2026 mempertemukan pemimpin teknologi, praktisi, dan mitra global untuk membahas agenda transformasi digital di sektor enterprise.\n\nSesi utama membahas strategi adopsi cloud yang terukur, keamanan informasi berbasis risiko, serta integrasi sistem HR dan ERP. Setiap sesi dirancang praktis sehingga peserta membawa pulang kerangka kerja yang bisa langsung diterapkan.\n\nTersedia sesi paralel untuk tim teknis dan diskusi meja bundar untuk pengambil keputusan.",
                'location' => 'Jakarta Convention Center',
                'organizer' => 'Nusakode',
                'starts_at' => $now->copy()->addMonths(2)->setTime(9, 0),
                'ends_at' => $now->copy()->addMonths(2)->setTime(16, 30),
                'register_url' => 'https://example.com/tech-summit-2026',
                'cta_label' => 'Daftar Sekarang',
                'agenda' => [
                    ['time' => '09:00', 'title' => 'Registrasi & Networking', 'description' => 'Penerimaan peserta dan kopi pagi.'],
                    ['time' => '09:30', 'title' => 'Keynote: Peta Jalan Digital 2026', 'description' => 'Tren dan prioritas teknologi enterprise tahun ini.'],
                    ['time' => '11:00', 'title' => 'Panel: Adopsi Cloud yang Terukur', 'description' => 'Studi kasus migrasi bertahap di berbagai sektor.'],
                    ['time' => '15:30', 'title' => 'Demo & Penutup', 'description' => 'Area demo solusi dan sesi tanya jawab.'],
                ],
                'speakers' => [
                    ['name' => 'Andi Pratama', 'position' => 'Chief Technology Officer, Nusakode', 'photo' => 'img/team-1.jpg'],
                    ['name' => 'Sinta Maharani', 'position' => 'Head of Product, Nusakode', 'photo' => 'img/team-2.jpg'],
                ],
                'published_at' => $now->copy()->subDays(5),
            ],
            [
                'type' => ResourceType::Event,
                'title' => 'Webinar: Keamanan Informasi untuk Rumah Sakit',
                'excerpt' => 'Webinar online membahas kesiapan rumah sakit menghadapi insiden siber.',
                'body' => "Rumah sakit kini menyimpan data pasien dalam jumlah besar dan menjadi target yang menarik bagi penyerang. Webinar ini membahas langkah praktis meningkatkan kesiapan.\n\nKami membahas identifikasi aset kritikal, penyusunan rencana respons insiden, serta peran tim IT dan manajemen dalam situasi darurat.",
                'location' => 'Zoom Webinar',
                'organizer' => 'Nusakode',
                'starts_at' => $now->copy()->addWeeks(3)->setTime(13, 0),
                'ends_at' => $now->copy()->addWeeks(3)->setTime(15, 0),
                'register_url' => 'https://example.com/webinar-keamanan-rs',
                'cta_label' => 'Ikut Webinar',
                'agenda' => [
                    ['time' => '13:00', 'title' => 'Pembukaan', 'description' => 'Konteks ancaman di sektor kesehatan.'],
                    ['time' => '13:20', 'title' => 'Menyusun Rencana Respons Insiden', 'description' => 'Kerangka kerja dan pembagian peran.'],
                ],
                'speakers' => [
                    ['name' => 'Dewi Anggraini', 'position' => 'Security Consultant, Nusakode', 'photo' => 'img/team-4.jpg'],
                ],
                'published_at' => $now->copy()->subDays(3),
            ],
            [
                'type' => ResourceType::Event,
                'title' => 'Workshop ERP untuk Manufaktur',
                'excerpt' => 'Workshop sehari membahas persiapan dan implementasi ERP di manufaktur.',
                'body' => "Workshop intensif ini memandu tim manufaktur menyiapkan implementasi ERP: pemetaan proses bisnis, kesiapan data, dan rencana go-live.\n\nPeserta mengerjakan studi kasus nyata dan mendapat daftar periksa yang bisa langsung dibawa ke rapat internal.",
                'location' => 'Hotel Borobudur, Jakarta',
                'organizer' => 'Nusakode',
                'starts_at' => $now->copy()->subMonths(2)->setTime(9, 0),
                'ends_at' => $now->copy()->subMonths(2)->setTime(17, 0),
                'recording_url' => 'https://example.com/rekaman-workshop-erp',
                'cta_label' => 'Lihat Rekaman',
                'gallery' => ['img/work-1.jpg', 'img/work-2.jpg', 'img/work-3.jpg'],
                'published_at' => $now->copy()->subMonths(3),
            ],
            [
                'type' => ResourceType::Event,
                'title' => 'Talkshow: Karier di Bidang Data',
                'excerpt' => 'Diskusi karier bersama praktisi data tentang peluang dan keterampilan.',
                'body' => "Talkshow ini membahas peta karier di bidang data, dari analis hingga data engineer, langsung dari praktisi yang bekerja di industri.\n\nPeserta mendapat gambaran keterampilan yang paling dicari dan tips menghadapi proses rekrutmen.",
                'location' => 'Universitas Cendana, Bandung',
                'organizer' => 'Nusakode',
                'starts_at' => $now->copy()->subMonth()->setTime(14, 0),
                'ends_at' => $now->copy()->subMonth()->setTime(16, 30),
                'cta_label' => 'Selengkapnya',
                'gallery' => ['img/about.jpg', 'img/work-4.jpg'],
                'published_at' => $now->copy()->subMonths(2),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function goLive(Carbon $now): array
    {
        return [
            [
                'type' => ResourceType::GoLive,
                'title' => 'Go-Live HRIS di Manufaktur Nasional',
                'industry' => 'Manufaktur',
                'excerpt' => 'Implementasi HRIS untuk 2.500 karyawan selesai tepat waktu dan stabil.',
                'body' => "Proyek implementasi HRIS untuk perusahaan manufaktur nasional telah resmi mengudara dan kini melayani sekitar 2.500 karyawan di beberapa lokasi pabrik.\n\nTantangan utama adalah konsolidasi data kehadiran dari perangkat berbeda dan perhitungan penggajian. Integrasi dibangun bertahap agar transisi tidak mengganggu operasional.",
                'metrics' => [
                    ['label' => 'Karyawan terlayani', 'value' => '2.500+'],
                    ['label' => 'Waktu proses payroll', 'value' => '-65%'],
                    ['label' => 'Lokasi pabrik', 'value' => '4'],
                ],
                'gallery' => ['img/work-1.jpg', 'img/about.jpg'],
                'published_at' => $now->copy()->subDays(10),
            ],
            [
                'type' => ResourceType::GoLive,
                'title' => 'Dashboard Keuangan untuk Bank Daerah',
                'industry' => 'Perbankan',
                'excerpt' => 'Dashboard keuangan real-time menggantikan pelaporan manual.',
                'body' => "Bank daerah membutuhkan visibilitas atas kinerja keuangan lintas cabang. Sebelumnya laporan disusun manual dan baru tersedia berhari-hari setelah periode tutup.\n\nKami membangun dashboard yang menarik data dari sistem inti secara terjadwal dan menyajikannya dalam satu tampilan.",
                'metrics' => [
                    ['label' => 'Waktu susun laporan', 'value' => '-80%'],
                    ['label' => 'Cabang terhubung', 'value' => '27'],
                ],
                'gallery' => ['img/work-2.jpg'],
                'published_at' => $now->copy()->subDays(24),
            ],
            [
                'type' => ResourceType::GoLive,
                'title' => 'Portal Ritel Multi-Cabang di Distribusi',
                'industry' => 'Ritel & Distribusi',
                'excerpt' => 'Portal pemesanan dan stok multi-cabang menggantikan pencatatan manual.',
                'body' => "Sebuah distributor mengelola puluhan cabang dengan pencatatan stok yang tersebar di berbagai berkas. Sering terjadi selisih antara stok fisik dan catatan.\n\nKami membangun portal terpusat untuk pemesanan, pemantauan stok, dan pelaporan penjualan antar cabang.",
                'metrics' => [
                    ['label' => 'Selisih stok', 'value' => '-90%'],
                    ['label' => 'Cabang aktif', 'value' => '18'],
                ],
                'gallery' => ['img/work-3.jpg', 'img/work-4.jpg'],
                'published_at' => $now->copy()->subDays(40),
            ],
            [
                'type' => ResourceType::GoLive,
                'title' => 'Sistem Akademik Terpadu di Universitas',
                'industry' => 'Pendidikan',
                'excerpt' => 'Sistem akademik dan PPDB terpadu mempermudah staf dan mahasiswa.',
                'body' => "Universitas memerlukan sistem yang menyatukan penerimaan mahasiswa baru, pengelolaan akademik, dan portal orang tua dalam satu platform.\n\nKami membangun aplikasi web yang mudah dipakai staf non-teknis.",
                'metrics' => [
                    ['label' => 'Pendaftar online', 'value' => '4.200'],
                    ['label' => 'Kepuasan pengguna', 'value' => '4,7/5'],
                ],
                'gallery' => ['img/about.jpg'],
                'published_at' => $now->copy()->subDays(58),
            ],
            [
                'type' => ResourceType::GoLive,
                'title' => 'Backup Terpusat untuk Perusahaan Energi',
                'industry' => 'Energi',
                'excerpt' => 'Solusi backup terpusat mengurangi risiko kehilangan data.',
                'body' => "Perusahaan energi memiliki data operasional yang tersebar di beberapa lokasi dengan kebijakan backup yang tidak seragam.\n\nKami menerapkan backup terpusat dengan jadwal otomatis dan pengujian pemulihan berkala.",
                'metrics' => [
                    ['label' => 'Lokasi terlindungi', 'value' => '6'],
                    ['label' => 'Waktu pemulihan', 'value' => '-75%'],
                ],
                'gallery' => ['img/hero.jpg'],
                'published_at' => $now->copy()->subDays(75),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function whitepapers(Carbon $now): array
    {
        return [
            [
                'type' => ResourceType::Whitepaper,
                'title' => 'Panduan Keamanan Informasi untuk Perusahaan',
                'excerpt' => 'Kerangka praktis menyusun kebijakan keamanan informasi berdasarkan ISO 27001.',
                'page_count' => 42,
                'body' => 'Keamanan informasi bukan sekadar pemasangan perangkat, melainkan tata kelola yang berjalan terus-menerus. Whitepaper ini merangkum langkah menyusun kebijakan yang realistis.',
                'toc' => ['Identifikasi aset dan penilaian risiko', 'Menyusun kontrol berdasarkan ISO 27001', 'Audit internal dan perbaikan berkelanjutan'],
                'file_path' => 'resources/files/whitepaper-keamanan-informasi.pdf',
                'cta_label' => 'Unduh Whitepaper',
                'published_at' => $now->copy()->subDays(14),
            ],
            [
                'type' => ResourceType::Whitepaper,
                'title' => '3 Insight Kunci Skills-Based Talent Management',
                'excerpt' => 'Cara mengelola talenta berbasis keterampilan di era otomatisasi.',
                'page_count' => 28,
                'body' => 'Perusahaan bergeser dari peran berbasis jabatan ke pendekatan berbasis keterampilan. Whitepaper ini membahas implikasinya bagi strategi SDM.',
                'toc' => ['Mengapa keterampilan lebih penting', 'Memetakan keterampilan organisasi', 'Teknologi pendukung'],
                'file_path' => 'resources/files/whitepaper-skills-based-talent.pdf',
                'cta_label' => 'Unduh Whitepaper',
                'published_at' => $now->copy()->subDays(20),
            ],
            [
                'type' => ResourceType::Whitepaper,
                'title' => 'Total Cost of Ownership: Cloud vs On-Premise',
                'excerpt' => 'Analisis biaya memilih cloud dibanding infrastruktur on-premise.',
                'page_count' => 34,
                'body' => 'Keputusan cloud sering diambil hanya berdasarkan harga langganan. Whitepaper ini membandingkan total biaya kepemilikan secara menyeluruh.',
                'toc' => ['Komponen biaya yang terlupakan', 'Model perbandingan TCO', 'Studi kasus migrasi'],
                'file_path' => 'resources/files/whitepaper-tco-cloud.pdf',
                'cta_label' => 'Unduh Whitepaper',
                'published_at' => $now->copy()->subDays(30),
            ],
            [
                'type' => ResourceType::Whitepaper,
                'title' => 'Menyiapkan Data untuk ERP',
                'excerpt' => 'Langkah praktis membersihkan data sebelum implementasi ERP.',
                'page_count' => 36,
                'body' => 'Kualitas data menentukan keberhasilan implementasi ERP. Whitepaper ini membahas cara mengaudit, membersihkan, dan memigrasikan data.',
                'toc' => ['Audit kualitas data', 'Pembersihan dan deduplikasi', 'Rencana migrasi'],
                'file_path' => 'resources/files/whitepaper-data-erp.pdf',
                'cta_label' => 'Unduh Whitepaper',
                'published_at' => $now->copy()->subDays(45),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function ebooks(Carbon $now): array
    {
        return [
            [
                'type' => ResourceType::Ebook,
                'title' => 'Langkah Pertama Adopsi ERP',
                'excerpt' => 'E-book untuk tim yang baru memulai perjalanan implementasi ERP.',
                'page_count' => 52,
                'body' => 'Banyak implementasi ERP gagal bukan karena teknologinya, tetapi karena persiapan yang kurang. E-book ini memandu tim internal menyiapkan diri.',
                'chapters' => [
                    ['title' => 'Memetakan proses bisnis', 'description' => 'Mengidentifikasi proses yang terdampak.'],
                    ['title' => 'Memilih modul dan menyiapkan data', 'description' => 'Menentukan prioritas dan data awal.'],
                    ['title' => 'Rencana go-live', 'description' => 'Peluncuran dan dukungan pasca implementasi.'],
                ],
                'file_path' => 'resources/files/ebook-adopsi-erp.pdf',
                'cta_label' => 'Unduh E-book',
                'published_at' => $now->copy()->subDays(18),
            ],
            [
                'type' => ResourceType::Ebook,
                'title' => 'Membangun Tim Keamanan Siber Pertama',
                'excerpt' => 'Panduan praktis menyusun tim dan proses keamanan dari nol.',
                'page_count' => 48,
                'body' => 'Tidak semua perusahaan punya tim keamanan khusus. E-book ini menjelaskan peran minimum yang perlu ada dan cara membangunnya bertahap.',
                'chapters' => [
                    ['title' => 'Peran dan tanggung jawab minimum', 'description' => 'Siapa mengerjakan apa di awal.'],
                    ['title' => 'Proses deteksi dan respons', 'description' => 'Alur kerja saat terjadi insiden.'],
                    ['title' => 'Meningkatkan kematangan', 'description' => 'Peta jalan 12 bulan.'],
                ],
                'file_path' => 'resources/files/ebook-tim-keamanan.pdf',
                'cta_label' => 'Unduh E-book',
                'published_at' => $now->copy()->subDays(33),
            ],
            [
                'type' => ResourceType::Ebook,
                'title' => 'Panduan Integrasi API untuk Pemula',
                'excerpt' => 'Dasar-dasar menghubungkan sistem lewat API agar data mengalir otomatis.',
                'page_count' => 40,
                'body' => 'Integrasi sistem sering terasa rumit. E-book ini menjelaskan konsep dasar API, pola integrasi umum, dan cara mengelola kegagalan.',
                'chapters' => [
                    ['title' => 'Konsep dasar API', 'description' => 'Istilah dan cara kerja.'],
                    ['title' => 'Pola integrasi umum', 'description' => 'Sinkronisasi dan antrean.'],
                    ['title' => 'Menangani kegagalan', 'description' => 'Retry, antrean, dan pemantauan.'],
                ],
                'file_path' => 'resources/files/ebook-integrasi-api.pdf',
                'cta_label' => 'Unduh E-book',
                'published_at' => $now->copy()->subDays(50),
            ],
            [
                'type' => ResourceType::Ebook,
                'title' => 'Checklist Transformasi Digital',
                'excerpt' => 'Daftar periksa praktis menyusun agenda transformasi digital.',
                'page_count' => 32,
                'body' => 'Transformasi digital sering dimulai tanpa peta yang jelas. E-book ini menyediakan daftar periksa untuk menilai kesiapan dan prioritas.',
                'chapters' => [
                    ['title' => 'Menilai kesiapan organisasi', 'description' => 'Memetakan kondisi saat ini.'],
                    ['title' => 'Menyusun prioritas', 'description' => 'Memilih inisiatif berdampak tinggi.'],
                    ['title' => 'Mengukur kemajuan', 'description' => 'Metrik dan tinjauan berkala.'],
                ],
                'file_path' => 'resources/files/ebook-checklist-transformasi.pdf',
                'cta_label' => 'Unduh E-book',
                'published_at' => $now->copy()->subDays(60),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function news(Carbon $now): array
    {
        return [
            [
                'type' => ResourceType::News,
                'title' => 'Nusakode Resmi Menjadi Mitra Anvis BI',
                'excerpt' => 'Kemitraan baru memperluas layanan business intelligence untuk klien.',
                'body' => 'Nusakode resmi menjalin kemitraan dengan Anvis BI untuk memperluas layanan analitik bisnis bagi klien di Indonesia. Kemitraan ini melengkapi portofolio solusi ERP yang sudah berjalan.',
                'external_url' => 'https://example.com/berita/mitra-anvis-bi',
                'published_at' => $now->copy()->subDays(4),
            ],
            [
                'type' => ResourceType::News,
                'title' => 'Nusakode Membuka Kantor Baru di Surabaya',
                'excerpt' => 'Ekspansi layanan untuk klien di wilayah Jawa Timur.',
                'body' => 'Untuk mendekatkan layanan ke klien, Nusakode membuka kantor perwakilan di Surabaya. Kantor ini menjadi basis tim implementasi dan dukungan untuk wilayah Jawa Timur.',
                'published_at' => $now->copy()->subDays(12),
            ],
            [
                'type' => ResourceType::News,
                'title' => 'Pencapaian: 120+ Proyek Terselesaikan',
                'excerpt' => 'Nusakode telah menyelesaikan lebih dari 120 proyek teknologi.',
                'body' => 'Nusakode mencatat pencapaian lebih dari 120 proyek yang telah berjalan di produksi, melayani klien dari berbagai industri seperti perbankan hingga manufaktur.',
                'published_at' => $now->copy()->subDays(22),
            ],
            [
                'type' => ResourceType::News,
                'title' => 'Liputan: Strategi Cloud untuk Perusahaan Menengah',
                'excerpt' => 'Tim Nusakode berbagi pandangan soal adopsi cloud yang terukur.',
                'body' => 'Dalam sebuah liputan media, tim Nusakode membahas pentingnya migrasi cloud bertahap dan bagaimana perusahaan menengah dapat memulainya tanpa mengganggu operasional.',
                'external_url' => 'https://example.com/media/strategi-cloud',
                'published_at' => $now->copy()->subDays(35),
            ],
            [
                'type' => ResourceType::News,
                'title' => 'Penghargaan Mitra Implementasi Terbaik 2026',
                'excerpt' => 'Nusakode menerima penghargaan atas kualitas implementasi.',
                'body' => 'Nusakode menerima penghargaan sebagai mitra implementasi terbaik tahun 2026, diberikan berdasarkan kualitas proyek, ketepatan waktu, dan kepuasan klien.',
                'published_at' => $now->copy()->subDays(48),
            ],
        ];
    }
}
