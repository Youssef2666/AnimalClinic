<?php

namespace App\Enums;

use ReflectionEnum;


enum DoctorSpecializationStatus : String {
    case CATS = 'قطط';
    case DOGS = 'كلاب';
    case BIRDS = 'طيور';
    case FISH = 'أسماك';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::CATS => 'قطط',
            self::DOGS => 'كلاب',
            self::BIRDS => 'طيور',
            self::FISH => 'أسماك',
        };
    }
}
