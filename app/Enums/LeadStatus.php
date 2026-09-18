<?php

namespace App\Enums;

enum LeadStatus: string
{
    case Baru = 'baru';
    case Dihubungi = 'dihubungi';
    case Diskusi = 'diskusi';
    case Proposal = 'proposal';
    case Deal = 'deal';
    case Ditolak = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Dihubungi => 'Dihubungi',
            self::Diskusi => 'Diskusi',
            self::Proposal => 'Proposal',
            self::Deal => 'Deal',
            self::Ditolak => 'Ditolak',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Baru => 'brand',
            self::Dihubungi => 'sky',
            self::Diskusi => 'amber',
            self::Proposal => 'violet',
            self::Deal => 'emerald',
            self::Ditolak => 'neutral',
        };
    }
}
