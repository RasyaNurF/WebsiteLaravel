<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'description',
        'about',
        'vision',
        'mission',
        'values',
        'logo_path',
        'cover_image_path',
        'email',
        'phone',
        'address',
        'founded_year',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'values' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return list<string>
     */
    public function valueList(): array
    {
        return collect($this->values ?? [])
            ->map(fn ($item) => is_string($item) ? trim($item) : trim((string) ($item['text'] ?? $item['title'] ?? '')))
            ->filter()
            ->values()
            ->all();
    }

    public static function active(): ?self
    {
        return static::query()->where('is_active', true)->latest()->first()
            ?? static::query()->latest()->first();
    }
}
