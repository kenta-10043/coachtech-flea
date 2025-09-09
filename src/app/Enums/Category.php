<?php

namespace App\Enums;

enum Category: int
{
    case FASHION = 1;
    case ELECTRONICS = 2;
    case HOME_INTERIOR = 3;
    case WOMEN = 4;
    case MEN = 5;
    case COSMETICS = 6;
    case BOOKS = 7;
    case GAMES = 8;
    case SPORTS = 9;
    case KITCHEN = 10;
    case HANDMADE = 11;
    case ACCESSORY = 12;
    case TOYS = 13;
    case BABY_KIDS = 14;

    public function label(): string
    {
        return match ($this) {
            self::FASHION => 'ファッション',
            self::ELECTRONICS => '家電',
            self::HOME_INTERIOR => 'インテリア',
            self::WOMEN => 'レディース',
            self::MEN => 'メンズ',
            self::COSMETICS => 'コスメ',
            self::BOOKS => '本',
            self::GAMES => 'ゲーム',
            self::SPORTS => 'スポーツ',
            self::KITCHEN => 'キッチン',
            self::HANDMADE => 'ハンドメイド',
            self::ACCESSORY => 'アクセサリー',
            self::TOYS => 'おもちゃ',
            self::BABY_KIDS => 'ベビー・キッズ',
        };
    }
}
