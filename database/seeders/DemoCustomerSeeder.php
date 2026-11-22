<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoCustomerSeeder extends Seeder
{
    public function run(): void
    {
        $demo = User::updateOrCreate(
            ['email' => 'customer@dashstore.test'],
            ['name' => 'Demo Customer', 'password' => 'password', 'email_verified_at' => now()],
        );

        $customers = User::factory()->count(10)->create()->push($demo);
        $products = Product::active()->inStock()->get();

        foreach ($customers as $customer) {
            foreach (range(1, fake()->numberBetween(1, 4)) as $i) {
                $this->createOrder($customer, $products->random(fake()->numberBetween(1, 4)));
            }
        }

        $demo->messages()->createMany([
            ['body' => 'Hi, when will my order be shipped?', 'from_admin' => false],
            ['body' => 'Hello! Your order is being prepared and will ship within 2 days.', 'from_admin' => true],
        ]);
    }

    private function createOrder(User $customer, $products): void
    {
        $items = $products->map(function (Product $product) {
            $quantity = fake()->numberBetween(1, 3);

            return [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->final_price,
                'quantity' => $quantity,
                'total' => round($product->final_price * $quantity, 2),
            ];
        });

        $subtotal = $items->sum('total');
        $createdAt = now()->subDays(fake()->numberBetween(0, 60));

        $order = Order::create([
            'user_id' => $customer->id,
            'status' => fake()->randomElement(OrderStatus::cases()),
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'shipping_name' => $customer->name,
            'shipping_phone' => $customer->phone ?? '0590000000',
            'shipping_address' => fake()->address(),
        ]);

        $order->forceFill(['created_at' => $createdAt, 'updated_at' => $createdAt])->save();
        $order->items()->createMany($items->all());
    }
}
