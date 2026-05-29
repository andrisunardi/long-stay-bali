<?php

namespace App\Enums\Property;

enum PropertyPowerBackup: int
{
    case Generator = 1;

    case Solar = 2;

    case None = 3;

    public function description(): string
    {
        return match ($this) {
            self::Generator => 'Generator',
            self::Solar => 'Solar',
            self::None => 'None',
        };
    }
}
