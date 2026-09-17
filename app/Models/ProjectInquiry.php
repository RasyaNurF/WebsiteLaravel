<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'company',
        'project_type',
        'budget_range',
        'project_detail',
    ];

    public const PROJECT_TYPES = [
        'Aplikasi Web',
        'Sistem Informasi / ERP',
        'Integrasi Sistem & API',
        'Aplikasi Mobile',
        'UI/UX & Product Design',
        'Maintenance & Pengembangan',
        'Lainnya',
    ];

    public const BUDGET_RANGES = [
        'Di bawah Rp 50 juta',
        'Rp 50 – 150 juta',
        'Rp 150 – 500 juta',
        'Di atas Rp 500 juta',
        'Belum tahu, minta arahan',
    ];
}
