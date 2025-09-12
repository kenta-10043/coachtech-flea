<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'item_id' => Item::factory(),
            'order_price' => 1800,
            'payment_method' => 1,
            'shopping_postal_code' => 123 - 4567,
            'shopping_address' => '配送先住所',
            'shopping_building' => '配送先建物名',
            'paid_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
