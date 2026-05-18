<?php

namespace App\Enums\Property;

enum PropertyBedroom: int
{
    case OneBedroom = 1;

    case TwoBedroom = 2;

    case ThreeBedroom = 3;

    case FourBedroom = 4;

    case FiveBedroom = 5;

    case SixBedroom = 6;

    public function description(): string
    {
        return match ($this) {
            self::OneBedroom => '1',
            self::TwoBedroom => '2',
            self::ThreeBedroom => '3',
            self::FourBedroom => '4',
            self::FiveBedroom => '5',
            self::SixBedroom => '6+',
        };
    }
}
