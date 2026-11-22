<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect(['Phones', 'Laptops', 'Headphones', 'Smart Watches', 'Accessories'])
            ->map(fn ($name) => Category::firstOrCreate(['name' => $name]));

        $brands = collect(['Apple', 'Samsung', 'Lenovo', 'Sony', 'Anker', 'Xiaomi'])
            ->map(fn ($name) => Brand::firstOrCreate(['name' => $name]));

        foreach ($categories as $category) {
            Product::factory()
                ->count(8)
                ->sequence(fn ($sequence) => [
                    'brand_id' => $brands->random()->id,
                    'is_featured' => $sequence->index < 2,
                ])
                ->for($category)
                ->create();

            Product::factory()->count(3)->discounted(fake()->randomElement([10, 15, 25]))
                ->for($category)->state(fn () => ['brand_id' => $brands->random()->id])
                ->create();

            Product::factory()->outOfStock()
                ->for($category)->state(fn () => ['brand_id' => $brands->random()->id])
                ->create();
        }
    }
}
