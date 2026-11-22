<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk()->assertSee('DashStore Admin');
    }

    public function test_admin_can_log_in_and_see_dashboard(): void
    {
        $admin = Admin::factory()->create();

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'password'])
            ->assertRedirect('/admin');

        $this->assertAuthenticatedAs($admin, 'admin');
        $this->get('/admin')->assertOk()->assertSee('Latest orders')->assertSee($admin->name);
    }

    public function test_customer_credentials_do_not_work_on_admin_login(): void
    {
        $customer = User::factory()->create();

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => $customer->email, 'password' => 'password'])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest('admin');
    }

    public function test_logged_in_customer_cannot_open_admin_dashboard(): void
    {
        $this->actingAs(User::factory()->create(), 'web')
            ->get('/admin')
            ->assertRedirect('/admin/login');
    }

    public function test_admin_session_does_not_log_in_the_storefront(): void
    {
        $this->actingAs(Admin::factory()->create(), 'admin')
            ->get('/account')
            ->assertRedirect('/login');
    }

    public function test_admin_can_log_out(): void
    {
        $this->actingAs(Admin::factory()->create(), 'admin')
            ->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->assertGuest('admin');
    }
}
