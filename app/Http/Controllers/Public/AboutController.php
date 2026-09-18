<?php

namespace App\Http\Controllers\Public;

use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CompanyProfile;
use App\Models\SiteSetting;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $profile = CompanyProfile::active();
        $teams = Team::query()
            ->where('status', PublishStatus::Published->value)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $testimonials = Testimonial::query()
            ->where('status', PublishStatus::Published->value)
            ->orderByDesc('is_featured')
            ->latest()
            ->limit(3)
            ->get();
        $clients = Client::query()->where('status', 'active')->orderBy('name')->limit(12)->get();

        return view('about', [
            'profile' => $profile,
            'teams' => $teams,
            'testimonials' => $testimonials,
            'clients' => $clients,
            'stats' => [
                'experience' => SiteSetting::value('stat_experience', '10+'),
                'projects' => SiteSetting::value('stat_projects', '120+'),
                'retention' => SiteSetting::value('stat_retention', '98%'),
            ],
            'values' => $profile?->valueList() ?? [
                'Kontrak kerja tertulis: lingkup, jadwal, biaya, dan garansi tercantum jelas.',
                'Tim tetap, bukan lepas: engineer yang mengerjakan proyek Anda adalah karyawan kami.',
                'Serah terima penuh: kode sumber, dokumentasi, kredensial, dan pelatihan operator.',
            ],
        ]);
    }
}
