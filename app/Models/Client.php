<?php

namespace App\Models;

use App\Enums\ClientStatus;
use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use GeneratesSlug;

    protected $fillable = [
        'name',
        'slug',
        'industry',
        'website',
        'logo_path',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => ClientStatus::class,
        ];
    }

    protected function slugSource(): string
    {
        return 'name';
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('industry', 'like', "%{$term}%")
                ->orWhere('contact_email', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
