<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_demo_accounts_are_created(): void
    {
        $this->assertDatabaseHas('admins', ['email' => 'admin@dashstore.test']);
        $this->assertDatabaseHas('users', ['email' => 'customer@dashstore.test']);
    }

    public function test_catalog_is_seeded_with_unique_slugs(): void
    {
        $this->assertSame(5, Category::count());
        $this->assertGreaterThan(0, Product::featured()->count());
        $this->assertSame(Product::count(), Product::distinct('slug')->count('slug'));
    }

    public function test_every_order_total_matches_its_items(): void
    {
        $this->assertGreaterThan(0, Order::count());

        Order::with('items')->each(function (Order $order) {
            $this->assertNotEmpty($order->items);
            $this->assertEquals(
                round($order->items->sum('total'), 2),
                (float) $order->subtotal,
                "Order {$order->number} subtotal does not match its items."
            );
            $this->assertStringStartsWith('DS-', $order->number);
        });
    }

    public function test_passwords_are_hashed(): void
    {
        $admin = Admin::firstWhere('email', 'admin@dashstore.test');
        $customer = User::firstWhere('email', 'customer@dashstore.test');

        $this->assertNotSame('password', $admin->password);
        $this->assertTrue(password_verify('password', $admin->password));
        $this->assertTrue(password_verify('password', $customer->password));
    }
}
