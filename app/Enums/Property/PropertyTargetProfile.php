<?php

namespace App\Enums\Property;

enum PropertyTargetProfile: int
{
    case Family = 1;

    case Couple = 2;

    case RemoteWorker = 3;

    case DesignLover = 4;

    public function description(): string
    {
        return match ($this) {
            self::Family => 'Family',
            self::Couple => 'Couple',
            self::RemoteWorker => 'Remote Worker',
            self::DesignLover => 'Design Lover',
        };
    }
}
