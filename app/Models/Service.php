<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'image_path',
        'technologies',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublishStatus::class,
        ];
    }

    public function industries(): BelongsToMany
    {
        return $this->belongsToMany(Industry::class);
    }

    /**
     * @return list<string>
     */
    public function technologyList(): array
    {
        return collect(explode(',', (string) $this->technologies))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
