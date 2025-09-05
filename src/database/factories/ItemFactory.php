<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Condition;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),
            'item_name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 10000),
            'item_image' => 'dummy.jpg',
            'status' => 1,
            'description' => $this->faker->sentence(),
        ];
    }
}
