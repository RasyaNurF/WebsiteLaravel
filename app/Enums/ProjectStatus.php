<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Planning = 'planning';
    case Development = 'development';
    case Testing = 'testing';
    case Live = 'live';
    case Maintenance = 'maintenance';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Planning => 'Planning',
            self::Development => 'Development',
            self::Testing => 'Testing',
            self::Live => 'Live',
            self::Maintenance => 'Maintenance',
            self::Completed => 'Completed',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Planning => 'neutral',
            self::Development => 'brand',
            self::Testing => 'amber',
            self::Live => 'emerald',
            self::Maintenance => 'violet',
            self::Completed => 'sky',
        };
    }
}
