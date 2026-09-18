<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesSlug
{
    protected static function bootGeneratesSlug(): void
    {
        static::creating(function ($model) {
            if (blank($model->slug)) {
                $model->slug = static::uniqueSlug($model->{$model->slugSource()});
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->slugSource()) && ! $model->isDirty('slug')) {
                $model->slug = static::uniqueSlug($model->{$model->slugSource()}, $model->getKey());
            }
        });
    }

    protected function slugSource(): string
    {
        return 'title';
    }

    protected static function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'item';
        $slug = $base;
        $suffix = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
