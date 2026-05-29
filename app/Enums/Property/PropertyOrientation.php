<?php

namespace App\Enums\Property;

enum PropertyOrientation: int
{
    case Morning = 1;

    case Afternoon = 2;

    case MixedSun = 3;

    public function description(): string
    {
        return match ($this) {
            self::Morning => 'Morning',
            self::Afternoon => 'Afternoon',
            self::MixedSun => 'Mixed Sun',
        };
    }
}
