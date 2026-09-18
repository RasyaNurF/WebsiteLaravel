<?php

namespace App\Enums;

enum MessageStatus: string
{
    case Unread = 'unread';
    case Read = 'read';
    case Replied = 'replied';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Unread => 'Belum dibaca',
            self::Read => 'Sudah dibaca',
            self::Replied => 'Dibalas',
            self::Archived => 'Arsip',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Unread => 'brand',
            self::Read => 'sky',
            self::Replied => 'emerald',
            self::Archived => 'neutral',
        };
    }
}
