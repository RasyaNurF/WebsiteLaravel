<?php

namespace App\Models;

use App\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'company',
        'photo_path',
        'quote',
        'is_featured',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'status' => PublishStatus::class,
        ];
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
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('quote', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
