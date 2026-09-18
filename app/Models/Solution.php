<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solution extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'solution_category_id',
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'body',
        'logo_path',
        'cover_image_path',
        'partner_name',
        'cta_label',
        'cta_url',
        'features',
        'benefits',
        'is_featured',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublishStatus::class,
            'features' => 'array',
            'benefits' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SolutionCategory::class, 'solution_category_id');
    }

    /**
     * @return list<string>
     */
    public function featureList(): array
    {
        return collect($this->features ?? [])
            ->map(fn ($item) => is_array($item) ? ($item['text'] ?? null) : $item)
            ->filter()
            ->values()
            ->all();
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%")
                ->orWhere('partner_name', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
