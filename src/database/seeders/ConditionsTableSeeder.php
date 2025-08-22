<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Condition;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('conditions')->truncate();
        DB::table('items')->truncate();

        DB::table('conditions')->insert([
            ['condition' => Condition::GOOD->value],
            ['condition' => Condition::NEAR_GOOD->value],
            ['condition' => Condition::FAIR->value],
            ['condition' => Condition::BAD->value],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
