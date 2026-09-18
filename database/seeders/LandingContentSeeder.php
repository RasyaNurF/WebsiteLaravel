<?php

namespace Database\Seeders;

use App\Enums\ClientStatus;
use App\Enums\ProjectStatus;
use App\Enums\PublishStatus;
use App\Models\Article;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LandingContentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        SiteSetting::putMany([
            'stat_experience' => '10+',
            'stat_projects' => '120+',
            'stat_retention' => '98%',
        ]);

        $services = [
            ['Pengembangan Web & Aplikasi', 'Kami membangun website, web application, dashboard, dan platform digital sesuai kebutuhan bisnis Anda.', 'Laravel, Vue, React, MySQL', 'img/work-1.jpg'],
            ['Sistem Informasi Bisnis', 'Sistem internal yang membantu perusahaan mengelola proses kerja secara lebih terstruktur, mulai dari keuangan, inventaris, SDM, hingga laporan.', 'Keuangan, Inventaris, SDM, Laporan', 'img/work-3.jpg'],
            ['Integrasi API & Sistem', 'Menghubungkan aplikasi, payment gateway, layanan pihak ketiga, dan sistem internal agar data dapat berjalan otomatis dan real-time.', 'API, Payment Gateway, Database', null],
            ['Aplikasi Mobile', 'Aplikasi Android dan iOS untuk layanan pelanggan, operasional, maupun kebutuhan bisnis khusus.', 'Android, iOS, Cross-Platform', 'img/work-2.jpg'],
            ['UI/UX & Product Design', 'Merancang antarmuka dan pengalaman pengguna yang sederhana, konsisten, dan mudah digunakan.', 'UI Design, UX Research, Prototyping', 'img/work-4.jpg'],
            ['Maintenance & Pengembangan', 'Pemeliharaan sistem, peningkatan fitur, monitoring, perbaikan bug, dan dukungan teknis berkelanjutan.', 'Monitoring, Bug Fix, SLA', 'img/hero.jpg'],
        ];

        foreach ($services as $index => [$title, $description, $technologies, $image]) {
            Service::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'description' => $description,
                    'technologies' => $technologies,
                    'image_path' => $image,
                    'sort_order' => $index + 1,
                    'status' => PublishStatus::Published,
                ],
            );
        }

        $industries = [
            ['Keuangan & Perbankan', 'Portal anggota, pengajuan pembiayaan, dan pelaporan yang dapat diaudit — menggantikan pencatatan manual yang tersebar.', 'Portal Anggota, Pelaporan, Audit Trail'],
            ['Ritel & Distribusi', 'Katalog, pemesanan antar cabang, dan integrasi stok sehingga data penjualan dan persediaan selalu selaras.', 'Stok Multi-Cabang, Pemesanan, Integrasi POS'],
            ['Pendidikan', 'Penerimaan peserta didik, akademik, dan komunikasi kampus dalam satu platform yang mudah dioperasikan staf non-teknis.', 'PPDB, Akademik, Portal Orang Tua'],
            ['Pemerintahan & BUMN', 'Layanan berbasis web dengan memperhatikan standar keamanan dan kearsipan, berikut dokumen pendukung pengadaan.', 'Layanan Publik, Kearsipan, Dokumen Pengadaan'],
        ];

        foreach ($industries as $index => [$name, $description, $technologies]) {
            Industry::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'technologies' => $technologies,
                    'sort_order' => $index + 1,
                    'status' => PublishStatus::Published,
                ],
            );
        }

        $clients = [
            ['Bank Arta', 'Keuangan', 'https://example.com'],
            ['Sinar Niaga', 'Distribusi', 'https://example.com'],
            ['Universitas Cendana', 'Pendidikan', 'https://example.com'],
        ];

        $clientModels = collect($clients)->mapWithKeys(function (array $row) {
            [$name, $industry, $website] = $row;

            return [
                $name => Client::query()->updateOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name, 'industry' => $industry, 'website' => $website, 'status' => ClientStatus::Active],
                ),
            ];
        });

        $works = [
            ['Dashboard Keuangan Internal', 'Perbankan', 'Bank Arta', 'img/work-1.jpg', 2024],
            ['Portal Pelaporan Penjualan', 'Distribusi', 'Sinar Niaga', 'img/work-2.jpg', 2024],
            ['Sistem Penerimaan Peserta Didik', 'Pendidikan', 'Universitas Cendana', 'img/work-3.jpg', 2023],
            ['Integrasi Sistem Pergudangan', 'Logistik', 'Sinar Niaga', 'img/work-4.jpg', 2023],
            ['Rekam Medis Elektronik', 'Kesehatan', 'Bank Arta', 'img/about.jpg', 2022],
            ['Monitoring Lini Produksi', 'Manufaktur', 'Sinar Niaga', 'img/hero.jpg', 2022],
            ['Portal Layanan Publik', 'Pemerintahan', 'Universitas Cendana', 'img/work-2.jpg', 2021],
            ['Katalog & Pemesanan Multi-Cabang', 'Ritel', 'Sinar Niaga', 'img/work-1.jpg', 2021],
        ];

        foreach ($works as $index => [$title, $category, $clientName, $image, $year]) {
            Portfolio::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'category' => $category,
                    'client_id' => $clientModels[$clientName]->id,
                    'thumbnail_path' => $image,
                    'year' => $year,
                    'sort_order' => $index + 1,
                    'is_featured' => $index < 4,
                    'status' => PublishStatus::Published,
                ],
            );
        }

        $projects = [
            ['Portal Pelaporan Penjualan', 'Sinar Niaga', 'Distribusi', ProjectStatus::Live, 'img/work-2.jpg'],
            ['Dashboard Keuangan Internal', 'Bank Arta', 'Perbankan', ProjectStatus::Maintenance, 'img/work-1.jpg'],
            ['Sistem Penerimaan Peserta Didik', 'Universitas Cendana', 'Pendidikan', ProjectStatus::Development, 'img/work-3.jpg'],
        ];

        foreach ($projects as [$name, $clientName, $category, $status, $image]) {
            Project::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'client_id' => $clientModels[$clientName]->id,
                    'category' => $category,
                    'status' => $status,
                    'image_path' => $image,
                ],
            );
        }

        $testimonials = [
            ['Rani Prameswari', 'Head of Operations', 'Bank Arta', 'Lingkup pekerjaan disepakati di awal dan tidak berubah-ubah di tengah jalan. Setiap termin dikaitkan dengan hasil yang bisa kami uji sendiri.'],
            ['Bayu Santoso', 'Direktur', 'Sinar Niaga', 'Tim kami yang awalnya mencatat di spreadsheet sekarang bekerja dalam satu sistem. Laporan bulanan yang dulu seminggu, sekarang selesai sehari.'],
            ['Dr. Lestari Widodo', 'Wakil Rektor', 'Universitas Cendana', 'Dokumentasinya lengkap dan kode diserahterimakan penuh. Tim internal kami bisa melanjutkan pengembangan tanpa ketergantungan.'],
        ];

        foreach ($testimonials as $index => [$name, $position, $company, $quote]) {
            Testimonial::query()->updateOrCreate(
                ['name' => $name, 'company' => $company],
                [
                    'position' => $position,
                    'quote' => $quote,
                    'is_featured' => $index === 0,
                    'status' => PublishStatus::Published,
                ],
            );
        }

        $articles = [
            ['Menyusun Kerangka Acuan Kerja Proyek Software Agar Tidak Bengkak', 'Panduan', 'img/work-3.jpg', '11 September 2026'],
            ['Jadwal Pengujian Penetrasi yang Wajar untuk Aplikasi Perusahaan', 'Keamanan', 'img/work-4.jpg', '9 September 2026'],
            ['Checklist Serah Terima Aplikasi dari Vendor ke Tim Internal', 'Operasional', 'img/work-2.jpg', '5 September 2026'],
        ];

        foreach ($articles as [$title, $category, $image, $date]) {
            Article::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'category' => $category,
                    'featured_image_path' => $image,
                    'excerpt' => 'Ringkasan artikel akan tampil di halaman insight.',
                    'status' => PublishStatus::Published,
                    'published_at' => Carbon::parse($date),
                ],
            );
        }
    }
}
