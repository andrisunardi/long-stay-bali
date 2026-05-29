<?php

namespace App\Enums\Property;

enum PropertyOwnerPriceFlexibility: int
{
    case Fixed = 1;

    case Negotiable = 2;

    public function description(): string
    {
        return match ($this) {
            self::Fixed => 'Fixed',
            self::Negotiable => 'Negotiable',
        };
    }
}
