<?php

namespace App\Enums;

enum BudgetType: int
{
    case Monthly = 1;

    case Yearly = 2;

    public function translate(): string
    {
        return match ($this) {
            self::Monthly => trans('index.monthly'),
            self::Yearly => trans('index.yearly'),
        };
    }
}
