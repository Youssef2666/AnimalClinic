<?php

namespace App\Enums;

use ReflectionEnum;
enum OrderStatus : string
{
    case DELIVERED = 'delivered';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';

    public static function values(): array
    {
        return array_column((new ReflectionEnum(self::class))->getCases(), 'name');
    }

    public function label(): string
    {
        return match ($this) {
            self::DELIVERED => 'Delivered',
            self::CONFIRMED => 'Confirmed',
            self::CANCELED => 'Canceled',
        };
    }
}
