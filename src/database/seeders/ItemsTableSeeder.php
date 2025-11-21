<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Condition;
use App\Enums\Status;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(['id' => 1]);
        $items = [
            [
                'user_id' => 1,
                'item_name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'item_image' => 'sample_images/Armani+Mens+Clock.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::GOOD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'item_image' => 'sample_images/HDD+Hard+Disk.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::NEAR_GOOD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => '玉ねぎ3束',
                'price' => 300,
                'brand_name' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'item_image' => 'sample_images/iLoveIMG+d.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::FAIR->value,
            ],
            [
                'user_id' => 1,
                'item_name' => '革靴',
                'price' => 4000,
                'brand_name' => null,
                'description' => 'クラシックなでデザインの革靴',
                'item_image' => 'sample_images/Leather+Shoes+Product+Photo.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::BAD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'ノートPC',
                'price' => 45000,
                'brand_name' => null,
                'description' => '高性能なノートパソコン',
                'item_image' => 'sample_images/Living+Room+Laptop.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::GOOD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'マイク',
                'price' => 8000,
                'brand_name' => null,
                'description' => '高音質のレコーディング用マイク',
                'item_image' => 'sample_images/Music+Mic+4632231.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::NEAR_GOOD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_name' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'item_image' => 'sample_images/Purse+fashion+pocket.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::FAIR->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'タンブラー',
                'price' => 500,
                'brand_name' => null,
                'description' => '使いやすいタンブラー',
                'item_image' => 'sample_images/Tumbler+souvenir.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::BAD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'コーヒーミル',
                'price' => 4000,
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'item_image' => 'sample_images/Waitress+with+Coffee+Grinder.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::GOOD->value,
            ],
            [
                'user_id' => 1,
                'item_name' => 'メイクセット',
                'price' => 2500,
                'brand_name' => null,
                'description' => '便利なメイクアップセット',
                'item_image' => 'sample_images/外出メイクアップセット.jpg',
                'status'      => Status::AVAILABLE->value,
                'condition_id' => Condition::NEAR_GOOD->value,
            ],
        ];
        DB::table('items')->insert($items);
    }
}
