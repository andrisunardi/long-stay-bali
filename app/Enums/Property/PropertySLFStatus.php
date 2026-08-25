<?php

namespace App\Enums\Property;

enum PropertySLFStatus: int
{
    case Available = 1;

    case InProccess = 2;

    case NotAvailable = 3;

    case NotApplicable = 4;
}
