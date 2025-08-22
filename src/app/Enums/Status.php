<?php

namespace App\Enums;

enum Status: int
{
    case AVAILABLE = 0;
    case SOLD = 1;

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::SOLD => 'Sold',
        };
    }
}
