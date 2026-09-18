<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'name',
        'slug',
        'client_id',
        'category',
        'description',
        'technologies',
        'started_at',
        'finished_at',
        'status',
        'image_path',
        'url',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'finished_at' => 'date',
            'status' => ProjectStatus::class,
        ];
    }

    protected function slugSource(): string
    {
        return 'name';
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
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
            $q->where('name', 'like', "%{$term}%")
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
