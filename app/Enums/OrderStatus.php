<?php

namespace App\Enums;

use ReflectionEnum;
enum OrderStatus : string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::CONFIRMED => 'Confirmed',
            self::CANCELED => 'Canceled',
        };
    }
}
