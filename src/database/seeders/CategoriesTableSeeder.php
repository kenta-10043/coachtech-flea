<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::table('category_item')->truncate();
        DB::table('categories')->insert([
            ['category' => Category::FASHION->value],
            ['category' => Category::ELECTRONICS->value],
            ['category' => Category::HOME_INTERIOR->value],
            ['category' => Category::WOMEN->value],
            ['category' => Category::MEN->value],
            ['category' => Category::COSMETICS->value],
            ['category' => Category::BOOKS->value],
            ['category' => Category::GAMES->value],
            ['category' => Category::SPORTS->value],
            ['category' => Category::KITCHEN->value],
            ['category' => Category::HANDMADE->value],
            ['category' => Category::ACCESSORY->value],
            ['category' => Category::TOYS->value],
            ['category' => Category::BABY_KIDS->value],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
