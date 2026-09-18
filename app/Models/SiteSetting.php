<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * @return array<string, string|null>
     */
    public static function allAsArray(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    public static function value(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function put(string $key, ?string $value, string $group = 'general'): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
    }

    /**
     * @param  array<string, string|null>  $values
     */
    public static function putMany(array $values, string $group = 'general'): void
    {
        foreach ($values as $key => $value) {
            static::put($key, $value, $group);
        }
    }

    public static function isMaintenanceMode(): bool
    {
        return filter_var(static::value('maintenance_mode', '0'), FILTER_VALIDATE_BOOL);
    }
}
