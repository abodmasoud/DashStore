<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_render(): void
    {
        $this->get('/login')->assertOk()->assertSee('Welcome back');
        $this->get('/register')->assertOk()->assertSee('Create your account');
    }

    public function test_customer_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Abdulrahman',
            'email' => 'abdulrahman@example.com',
            'phone' => '0599123456',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated('web');
        $this->assertDatabaseHas('users', ['email' => 'abdulrahman@example.com', 'phone' => '0599123456']);
        $this->assertNotSame('secret-password', User::first()->password);
    }

    public function test_registration_requires_unique_email_and_confirmed_password(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->from('/register')->post('/register', [
            'name' => 'Someone',
            'email' => 'taken@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'different',
        ])->assertRedirect('/register')->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest('web');
    }

    public function test_customer_can_log_in_and_is_sent_to_intended_page(): void
    {
        $user = User::factory()->create();

        $this->get('/account')->assertRedirect('/login');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/account');

        $this->assertAuthenticatedAs($user, 'web');
    }

    public function test_customer_cannot_log_in_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest('web');
    }

    public function test_login_is_rate_limited_after_five_failed_attempts(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 5) as $i) {
            $this->post('/login', ['email' => $user->email, 'password' => 'wrong']);
        }

        // Even the correct password is rejected while locked out.
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest('web');
    }

    public function test_customer_can_view_account_and_log_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/account')->assertOk()->assertSee($user->email);

        $this->actingAs($user)->post('/logout')->assertRedirect('/');
        $this->assertGuest('web');
    }

    public function test_logged_in_customer_is_redirected_away_from_login(): void
    {
        $this->actingAs(User::factory()->create())->get('/login')->assertRedirect('/');
    }
}
