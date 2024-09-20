<?php

namespace App\Enums;
use ReflectionEnum;
enum AppointmentTypeStatus : string
{
    case CONSULTATION = 'consultation';
    case SURGERY = 'surgery';
    case VACCINATION = 'vaccination';
    case FOLLOW_UP = 'follow-up';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::CONSULTATION => 'Consultation',
            self::SURGERY => 'Surgery',
            self::VACCINATION => 'Vaccination',
            self::FOLLOW_UP => 'Follow-up',
        };
    }
}
