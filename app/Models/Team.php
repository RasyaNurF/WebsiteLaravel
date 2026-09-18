<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'name',
        'slug',
        'position',
        'photo_path',
        'bio',
        'linkedin_url',
        'instagram_url',
        'github_url',
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

    public function initials(): string
    {
        $words = preg_split('/\s+/', trim((string) $this->name)) ?: [];

        return collect($words)
            ->take(2)
            ->map(fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('position', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
