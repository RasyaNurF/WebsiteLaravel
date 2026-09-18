<?php

namespace App\Enums;

enum PublishStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Draft => 'neutral',
            self::Published => 'emerald',
        };
    }
}
