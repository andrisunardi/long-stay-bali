<?php

namespace App\Enums\Property;

enum PropertyType: int
{
    case Villa = 1;

    public function description(): string
    {
        return match ($this) {
            self::Villa => 'Villa',
        };
    }
}
