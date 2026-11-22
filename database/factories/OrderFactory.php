<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 800);

        return [
            'user_id' => User::factory(),
            'status' => fake()->randomElement(OrderStatus::cases()),
            'subtotal' => $subtotal,
            'discount' => 0,
            'shipping' => 0,
            'total' => $subtotal,
            'shipping_name' => fake()->name(),
            'shipping_phone' => fake()->numerify('059#######'),
            'shipping_address' => fake()->address(),
        ];
    }
}
