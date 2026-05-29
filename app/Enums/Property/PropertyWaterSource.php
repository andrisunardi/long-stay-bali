<?php

namespace App\Enums\Property;

enum PropertyWaterSource: int
{
    case PDAM = 1;

    case Well = 2;

    case Mixed = 3;

    public function description(): string
    {
        return match ($this) {
            self::PDAM => 'PDAM',
            self::Well => 'Well',
            self::Mixed => 'Mixed',
        };
    }
}
