<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectInquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'project_type',
        'budget_range',
        'project_detail',
        'status',
        'admin_note',
        'handled_by',
        'handled_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
            'handled_at' => 'datetime',
        ];
    }

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

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('project_type', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
