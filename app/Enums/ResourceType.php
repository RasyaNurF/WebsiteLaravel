<?php

namespace App\Enums;

enum ResourceType: string
{
    case Event = 'event';
    case Whitepaper = 'whitepaper';
    case Ebook = 'ebook';
    case News = 'news';
    case GoLive = 'go-live';

    public function label(): string
    {
        return match ($this) {
            self::Event => 'Event',
            self::Whitepaper => 'Whitepaper',
            self::Ebook => 'E-book',
            self::News => 'News',
            self::GoLive => 'Go-Live',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Event => 'brand',
            self::Whitepaper => 'sky',
            self::Ebook => 'violet',
            self::News => 'emerald',
            self::GoLive => 'amber',
        };
    }
}
