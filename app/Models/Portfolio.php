<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'title',
        'slug',
        'client_id',
        'project_id',
        'category',
        'description',
        'challenge',
        'solution',
        'result',
        'technologies',
        'thumbnail_path',
        'gallery',
        'url',
        'year',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'status' => PublishStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('sort_order')->orderBy('id');
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
                ->orWhere('category', 'like', "%{$term}%")
                ->orWhere('technologies', 'like', "%{$term}%")
                ->orWhereHas('client', fn (Builder $client) => $client->where('name', 'like', "%{$term}%"));
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
