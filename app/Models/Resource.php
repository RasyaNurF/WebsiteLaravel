<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Enums\ResourceType;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image_path',
        'file_path',
        'external_url',
        'register_url',
        'recording_url',
        'location',
        'organizer',
        'industry',
        'page_count',
        'agenda',
        'speakers',
        'gallery',
        'metrics',
        'toc',
        'chapters',
        'cta_label',
        'cta_url',
        'starts_at',
        'ends_at',
        'is_featured',
        'sort_order',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => ResourceType::class,
            'status' => PublishStatus::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'page_count' => 'integer',
            'agenda' => 'array',
            'speakers' => 'array',
            'gallery' => 'array',
            'metrics' => 'array',
            'toc' => 'array',
            'chapters' => 'array',
        ];
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at?->isFuture() ?? false;
    }

    public function isPast(): bool
    {
        return $this->ends_at?->isPast() ?? ($this->starts_at?->isPast() ?? false);
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%")
                ->orWhere('location', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
