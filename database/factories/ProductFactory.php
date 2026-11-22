<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => Str::title(fake()->unique()->words(3, true)),
            'sku' => Str::upper(fake()->unique()->bothify('DS-####-??')),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 5, 500),
            'discount_price' => null,
            'quantity' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'is_featured' => false,
        ];
    }

    public function discounted(int $percent = 20): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_price' => round($attributes['price'] * (100 - $percent) / 100, 2),
        ]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }

    public function outOfStock(): static
    {
        return $this->state(['quantity' => 0]);
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
