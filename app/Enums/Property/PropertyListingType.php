<?php

namespace App\Enums\Property;

enum PropertyListingType: int
{
    case ForRent = 1;

    case ForSale = 2;

    case ForRentAndSale = 3;

    public function description(): string
    {
        return match ($this) {
            self::ForRent => trans('property.listing_type.for_rent'),
            self::ForSale => trans('property.listing_type.for_sales'),
            self::ForRentAndSale => trans('property.listing_type.for_rent_and_for_sales'),
        };
    }
}
