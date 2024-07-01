<?php

namespace App\Enums;

use ReflectionEnum;

enum GenderStatus: string {
    case MALE = 'male';
    case FEMALE = 'female';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
        };
    }
}
