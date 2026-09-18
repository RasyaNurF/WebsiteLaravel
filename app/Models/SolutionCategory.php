<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolutionCategory extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'icon',
        'image_path',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublishStatus::class,
        ];
    }

    protected function slugSource(): string
    {
        return 'name';
    }

    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class);
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
