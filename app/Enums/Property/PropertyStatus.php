<?php

namespace App\Enums\Property;

enum PropertyStatus: int
{
    case Pending = 1;

    case AcceptUpper = 2;

    case AcceptPremium = 3;

    case Reject = 4;

    case Escalate = 5;

    case Ready = 6;

    case UnderConstruction = 7;

    case OffPlan = 8;

    public function description(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::AcceptUpper => 'Accept Upper',
            self::AcceptPremium => 'Accept Premium',
            self::Reject => 'Reject',
            self::Escalate => 'Escalate For Arbitration',
            self::Ready => 'Ready',
            self::UnderConstruction => 'UnderConstruction',
            self::OffPlan => 'Off-Plan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::AcceptUpper => 'success',
            self::AcceptPremium => 'primary',
            self::Reject => 'danger',
            self::Escalate => 'info',
            self::Ready => 'success',
            self::UnderConstruction => 'warning',
            self::OffPlan => 'danger',
        };
    }
}
