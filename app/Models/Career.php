<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'employment_type',
        'description',
        'requirements',
        'responsibilities',
        'salary_range',
        'deadline',
        'is_remote',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'is_remote' => 'boolean',
            'status' => PublishStatus::class,
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class);
    }

    public function isOpen(): bool
    {
        return $this->status === PublishStatus::Published
            && ($this->deadline === null || $this->deadline->isFuture() || $this->deadline->isToday());
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('department', 'like', "%{$term}%")
                ->orWhere('location', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
