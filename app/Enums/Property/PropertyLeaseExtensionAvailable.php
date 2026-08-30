<?php

namespace App\Enums\Property;

enum PropertyLeaseExtensionAvailable: int
{
    case Yes = 1;

    case No = 2;

    case ToBeConfirmed = 3;
}
