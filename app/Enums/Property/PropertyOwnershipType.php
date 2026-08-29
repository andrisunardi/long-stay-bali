<?php

namespace App\Enums\Property;

enum PropertyOwnershipType: int
{
    case Freehold = 1;

    case Leasehold = 2;

    public function description(): string
    {
        return match ($this) {
            self::Freehold => 'Freehold',
            self::Leasehold => 'Leasehold',
        };
    }

    public function translate(): string
    {
        return match ($this) {
            self::Freehold => trans('index.freehold'),
            self::Leasehold => trans('index.leasehold'),
        };
    }
}
