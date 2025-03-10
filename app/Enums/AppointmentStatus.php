<?php

namespace App\Enums;
use ReflectionEnum;

enum AppointmentStatus : string
{
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';


    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::CONFIRMED => 'Confirmed',
            self::CANCELED => 'Canceled',
            self::COMPLETED => 'Completed',
        };
    }
}
