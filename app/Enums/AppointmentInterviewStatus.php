<?php

namespace App\Enums;
use ReflectionEnum;

enum AppointmentInterviewStatus : string
{
    case ONLINE = 'online';
    case OFFLINE = 'offline';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::ONLINE => 'Online',
            self::OFFLINE => 'Offline',
        };
    }
}
