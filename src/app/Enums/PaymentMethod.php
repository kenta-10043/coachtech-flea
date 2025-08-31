<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case KONBINI = 1;
    case CARD = 2;

    public function label(): string
    {
        return match ($this) {
            self::KONBINI => 'コンビニ払い',
            self::CARD => 'カード払い',
        };
    }

    public function stripeCode(): string
    {
        return match ($this) {
            self::KONBINI => 'konbini',
            self::CARD => 'card',
        };
    }
}
