<?php

namespace App\Enums\Property;

enum PropertyBedroom: int
{
    case OneBedroom = 1;

    case TwoBedroom = 2;

    case ThreeBedroom = 3;

    case FourBedroom = 4;

    public function description(): string
    {
        return match ($this) {
            self::OneBedroom => '1',
            self::TwoBedroom => '2',
            self::ThreeBedroom => '3',
            self::FourBedroom => '4',
        };
    }

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::OneBedroom->value => '1',
            self::TwoBedroom->value => '2',
            self::ThreeBedroom->value => '3',
            self::FourBedroom->value => '4',
        };
    }
}
