<?php

namespace App\Enums;

enum Status: int
{
    case AVAILABLE = 1;
    case SOLD = 2;

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::SOLD => 'Sold',
        };
    }
}
