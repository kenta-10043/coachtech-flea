<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConditionsTableSeeder::class,
            ItemsTableSeeder::class,
            CategoriesTableSeeder::class,
            ItemCategoryTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
