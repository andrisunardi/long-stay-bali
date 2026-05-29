<?php

namespace App\Enums\Property;

enum PropertyElectricity: int
{
    case Standard = 1;

    case Solar = 2;

    case Hybrid = 3;

    public function description(): string
    {
        return match ($this) {
            self::Standard => 'Standard',
            self::Solar => 'Solar',
            self::Hybrid => 'Hybrid',
        };
    }
}
