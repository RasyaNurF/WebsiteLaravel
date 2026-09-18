<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image_path',
        'category',
        'blog_category_id',
        'tags',
        'author_id',
        'seo_title',
        'meta_description',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'status' => PublishStatus::class,
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function categoryName(): string
    {
        return $this->blogCategory?->name ?: (string) ($this->category ?: 'Insight');
    }

    /**
     * @return list<string>
     */
    public function tagList(): array
    {
        return collect(explode(',', (string) $this->tags))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    public function readingTime(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags((string) $this->body)) / 200));
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('category', 'like', "%{$term}%")
                ->orWhere('tags', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
