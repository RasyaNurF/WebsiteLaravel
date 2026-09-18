<?php

namespace App\Enums;

enum ClientStatus: string
{
    case Active = 'active';
    case Prospect = 'prospect';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Prospect => 'Prospek',
            self::Inactive => 'Tidak aktif',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Active => 'emerald',
            self::Prospect => 'brand',
            self::Inactive => 'neutral',
        };
    }
}
