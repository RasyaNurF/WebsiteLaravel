<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplication extends Model
{
    protected $fillable = [
        'career_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'cv_path',
        'portfolio_url',
        'status',
    ];

    public const STATUSES = ['new', 'reviewed', 'interview', 'hired', 'rejected'];

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'new' => 'Baru',
            'reviewed' => 'Ditinjau',
            'interview' => 'Interview',
            'hired' => 'Diterima',
            'rejected' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function statusTone(): string
    {
        return match ($this->status) {
            'new' => 'brand',
            'reviewed' => 'sky',
            'interview' => 'amber',
            'hired' => 'emerald',
            'rejected' => 'neutral',
            default => 'neutral',
        };
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
