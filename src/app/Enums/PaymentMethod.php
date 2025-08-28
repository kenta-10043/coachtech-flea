<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case UNSELECTED = 1;
    case CONVENIENCE = 2;
    case CREDIT = 3;

    public function label(): string
    {
        return match ($this) {
            self::UNSELECTED => '未選択',
            self::CONVENIENCE => 'コンビニ払い',
            self::CREDIT => 'カード払い',
        };
    }
}
