<?php

namespace Database\Seeders;

use App\Enums\PublishStatus;
use App\Models\Solution;
use App\Models\SolutionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SolutionContentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            [
                'name' => 'Human Capital Management',
                'tagline' => 'Kelola talenta dari rekrutmen hingga pengembangan.',
                'description' => 'Optimalkan semua aspek manajemen SDM mulai dari rekrutmen, penggajian, hingga pengembangan karier.',
                'icon' => 'users',
                'solutions' => [
                    [
                        'title' => 'SAP SuccessFactors',
                        'partner_name' => 'SAP',
                        'subtitle' => 'Manajemen pengalaman karyawan end-to-end.',
                        'excerpt' => 'Otomatiskan dan integrasikan semua aspek manajemen SDM, dari perekrutan hingga pengembangan karier.',
                        'features' => ['Employee Central', 'Talent Management', 'Performance & Goals', 'HR Analytics'],
                        'benefits' => ['Satu sumber data karyawan', 'Keputusan berbasis analitik SDM', 'Pengalaman karyawan lebih baik'],
                        'is_featured' => true,
                    ],
                    [
                        'title' => 'Talent Club',
                        'partner_name' => 'TalentClub',
                        'subtitle' => 'Platform rekrutmen dengan ATS.',
                        'excerpt' => 'Temukan peluang kerja dan kelola proses rekrutmen secara efisien dalam satu tempat.',
                        'features' => ['Job posting', 'Applicant tracking', 'Career site'],
                        'benefits' => ['Perekrutan lebih cepat', 'Kandidat terpusat'],
                    ],
                    [
                        'title' => 'Haermes HRIS',
                        'partner_name' => 'Haermes',
                        'subtitle' => 'Administrasi SDM digital.',
                        'excerpt' => 'Basis data karyawan, perhitungan penggajian, manajemen kehadiran, dan lainnya.',
                        'features' => ['Database karyawan', 'Payroll', 'Absensi'],
                        'benefits' => ['Administrasi rapi', 'Penggajian akurat'],
                    ],
                ],
            ],
            [
                'name' => 'CRM & Customer Experience',
                'tagline' => 'Perkuat interaksi dengan pelanggan.',
                'description' => 'Integrasikan analisis dan otomatisasi untuk meningkatkan interaksi pelanggan dan pertumbuhan bisnis.',
                'icon' => 'message',
                'solutions' => [
                    [
                        'title' => 'Freshdesk',
                        'partner_name' => 'Freshworks',
                        'subtitle' => 'Helpdesk berbasis tiket.',
                        'excerpt' => 'Kelola kebutuhan pelanggan dengan sistem tiket dan berikan dukungan terbaik.',
                        'features' => ['Ticketing', 'Knowledge base', 'Otomatisasi'],
                        'benefits' => ['Kepuasan pelanggan meningkat', 'SLA terukur'],
                    ],
                    [
                        'title' => 'Freshsales',
                        'partner_name' => 'Freshworks',
                        'subtitle' => 'CRM untuk tim penjualan.',
                        'excerpt' => 'Kelola penjualan melalui smart pipeline dan fokus pada prospek berpotensi tinggi.',
                        'features' => ['Smart pipeline', 'Lead scoring', 'Email integration'],
                        'benefits' => ['Pipeline transparan', 'Konversi meningkat'],
                    ],
                ],
            ],
            [
                'name' => 'Infrastruktur TI',
                'tagline' => 'Efisiensi operasional dan konektivitas.',
                'description' => 'Tingkatkan efisiensi operasional dengan solusi infrastruktur dan cloud.',
                'icon' => 'cloud',
                'solutions' => [
                    [
                        'title' => 'Huawei Cloud',
                        'partner_name' => 'Huawei',
                        'subtitle' => 'Cloud yang andal dan skalabel.',
                        'excerpt' => 'Kelola database, jaringan, penyimpanan, dan keamanan dalam satu platform.',
                        'features' => ['Compute', 'Database', 'Storage', 'Security'],
                        'benefits' => ['Skalabilitas tinggi', 'Biaya efisien'],
                    ],
                    [
                        'title' => 'WhaTap',
                        'subtitle' => 'Pemantauan aplikasi real-time.',
                        'excerpt' => 'Deteksi akar masalah dengan cepat dan eliminasi risiko sebelum mengganggu operasional.',
                        'features' => ['APM', 'Real-time insight', 'Alerting'],
                        'benefits' => ['Downtime berkurang', 'Respons lebih cepat'],
                    ],
                ],
            ],
            [
                'name' => 'IT Security',
                'tagline' => 'Lindungi integritas data.',
                'description' => 'Perlindungan menyeluruh untuk endpoint, cloud, dan data dari ancaman siber.',
                'icon' => 'shield',
                'solutions' => [
                    [
                        'title' => 'Backup as a Service',
                        'subtitle' => 'Cadangan data terkelola.',
                        'excerpt' => 'Solusi backup dan recovery yang andal untuk mengurangi risiko kehilangan data.',
                        'features' => ['Automated backup', 'Disaster recovery', 'Retention policy'],
                        'benefits' => ['Risiko downtime turun', 'Data terlindungi'],
                    ],
                    [
                        'title' => 'Managed Detection & Response',
                        'subtitle' => 'Pemantauan ancaman 24/7.',
                        'excerpt' => 'Pantau potensi ancaman dan perkuat keamanan di seluruh lingkungan cloud perusahaan.',
                        'features' => ['Threat detection', 'Incident response'],
                        'benefits' => ['Respons insiden cepat', 'Visibilitas ancaman'],
                    ],
                ],
            ],
            [
                'name' => 'ERP & Business Intelligence',
                'tagline' => 'Efisiensi operasional dan insight.',
                'description' => 'Sistem ERP dan perangkat BI untuk pengambilan keputusan berbasis data.',
                'icon' => 'chart',
                'solutions' => [
                    [
                        'title' => 'SAP S/4HANA Cloud',
                        'partner_name' => 'SAP',
                        'subtitle' => 'ERP real-time untuk perusahaan.',
                        'excerpt' => 'Menyederhanakan proses bisnis secara real-time dan mendorong transformasi digital.',
                        'features' => ['Finance', 'Supply chain', 'Manufacturing'],
                        'benefits' => ['Proses terintegrasi', 'Keputusan real-time'],
                        'is_featured' => true,
                    ],
                    [
                        'title' => 'Anvis BI',
                        'partner_name' => 'Anvis',
                        'subtitle' => 'Dasbor dan pelaporan bisnis.',
                        'excerpt' => 'Ubah data mentah menjadi insight melalui dasbor intuitif dan pelaporan komprehensif.',
                        'features' => ['Dashboard', 'Reporting', 'Data connectors'],
                        'benefits' => ['Keputusan berbasis data', 'Laporan cepat'],
                    ],
                ],
            ],
        ];

        foreach ($categories as $index => $data) {
            $category = SolutionCategory::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'tagline' => $data['tagline'],
                    'description' => $data['description'],
                    'icon' => $data['icon'],
                    'sort_order' => $index + 1,
                    'status' => PublishStatus::Published,
                ],
            );

            foreach ($data['solutions'] as $order => $solution) {
                Solution::query()->updateOrCreate(
                    ['slug' => Str::slug($solution['title'])],
                    [
                        'solution_category_id' => $category->id,
                        'title' => $solution['title'],
                        'subtitle' => $solution['subtitle'] ?? null,
                        'excerpt' => $solution['excerpt'] ?? null,
                        'partner_name' => $solution['partner_name'] ?? null,
                        'features' => $solution['features'] ?? [],
                        'benefits' => $solution['benefits'] ?? [],
                        'is_featured' => $solution['is_featured'] ?? false,
                        'cta_label' => 'Konsultasi Sekarang',
                        'cta_url' => '/kontak',
                        'sort_order' => $order + 1,
                        'status' => PublishStatus::Published,
                    ],
                );
            }
        }
    }
}
