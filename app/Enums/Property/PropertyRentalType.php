<?php

namespace App\Enums\Property;

enum PropertyRentalType: int
{
    case Monthly = 1;

    case Yearly = 2;

    case Both = 3;

    public function description(): string
    {
        return match ($this) {
            self::Monthly => 'Monthly',
            self::Yearly => 'Yearly',
            self::Both => 'Both',
        };
    }

    public function translate(): string
    {
        return match ($this) {
            self::Monthly => trans('index.monthly'),
            self::Yearly => trans('index.yearly'),
            self::Both => trans('index.both'),
        };
    }
}
