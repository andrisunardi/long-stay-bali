<?php

namespace App\Enums\Property;

enum PropertyRoadAccess: int
{
    case Public = 1;

    case Private = 2;

    case Shared = 3;
}
