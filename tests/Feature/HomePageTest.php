<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_for_guests(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Log in')
            ->assertSee('Sign up');
    }

    public function test_home_page_shows_only_active_featured_products(): void
    {
        $featured = Product::factory()->featured()->create();
        $notFeatured = Product::factory()->create();
        $inactive = Product::factory()->featured()->inactive()->create();

        $this->get('/')
            ->assertOk()
            ->assertSee($featured->name)
            ->assertDontSee($notFeatured->name)
            ->assertDontSee($inactive->name);
    }
}
