<?php

namespace App\Enums;

enum Condition: int
{
    case GOOD = 1;
    case NEAR_GOOD = 2;
    case FAIR = 3;
    case BAD = 4;

    public function label(): string
    {
        return match ($this) {
            self::GOOD => '良好',
            self::NEAR_GOOD => '目立った傷や汚れなし',
            self::FAIR => 'やや傷や汚れあり',
            self::BAD => '状態が悪い',
        };
    }
}
