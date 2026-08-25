<?php

namespace App\Enums\Property;

enum PropertyLandTitle: int
{
    case SHM = 1;

    case HGB = 2;

    case HakPakai = 3;

    case Other = 4;

    public function description(): string
    {
        return match ($this) {
            self::SHM => 'SHM',
            self::HGB => 'HGB',
            self::HakPakai => 'Hak Pakai',
            self::Other => 'Other',
        };
    }
}
