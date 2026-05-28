<?php

namespace App\Enums\Property;

enum PropertyLivingStyle: int
{
    case Open = 1;

    case Closed = 2;

    case Mixed = 3;

    public function translate(): string
    {
        return match ($this) {
            self::Open => trans('property.living_style_open'),
            self::Closed => trans('property.living_style_closed'),
            self::Mixed => trans('property.living_style_mixed'),
        };
    }
}
