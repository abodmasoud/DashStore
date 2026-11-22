<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductPricingTest extends TestCase
{
    public function test_final_price_uses_discount_when_lower_than_price(): void
    {
        $product = new Product(['price' => 100, 'discount_price' => 80]);

        $this->assertTrue($product->has_discount);
        $this->assertEquals(80, $product->final_price);
        $this->assertSame(20, $product->discount_percent);
    }

    public function test_discount_is_ignored_when_not_lower_than_price(): void
    {
        $product = new Product(['price' => 100, 'discount_price' => 120]);

        $this->assertFalse($product->has_discount);
        $this->assertEquals(100, $product->final_price);
    }

    public function test_product_without_discount_uses_base_price(): void
    {
        $product = new Product(['price' => 49.99]);

        $this->assertFalse($product->has_discount);
        $this->assertEquals(49.99, $product->final_price);
        $this->assertSame(0, $product->discount_percent);
    }
}
