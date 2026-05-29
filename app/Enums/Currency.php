<?php

namespace App\Enums;

enum Currency: string
{
    case IDR = 'idr';

    case USD = 'usd';

    case AUD = 'aud';

    case EUR = 'eur';

    case GBP = 'gbp';

    public function icon(): string
    {
        return match ($this) {
            self::IDR => 'fas fa-rupiah-sign',
            self::USD => 'fas fa-dollar-sign',
            self::AUD => 'fas fa-dollar-sign',
            self::EUR => 'fas fa-euro-sign',
            self::GBP => 'fas fa-sterling-sign',
        };
    }
}
