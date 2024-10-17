<?php

namespace App\Enums;

use ReflectionEnum;


enum DoctorSpecializationStatus : String {
    case CATS = 'cats';
    case DOGS = 'dogs';
    case BIRDS = 'birds';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::CATS => 'Cats',
            self::DOGS => 'Dogs',
            self::BIRDS => 'Birds',
        };
    }
}
