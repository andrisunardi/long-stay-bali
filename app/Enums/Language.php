<?php

namespace App\Enums;

enum Language: string
{
    case English = 'en';

    case Indonesia = 'id';

    case French = 'fr';

    public function flag(): string
    {
        return match ($this) {
            self::English => 'fi fi-us',
            self::Indonesia => 'fi fi-id',
            self::French => 'fi fi-fr',
        };
    }
}
