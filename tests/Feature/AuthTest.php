<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_login_and_register_pages(): void
    {
        $this->get(route('login'))->assertOk();
        $this->get(route('register'))->assertOk();
    }

    public function test_user_can_register(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $loginResponse = $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->post(route('logout'));

        $logoutResponse->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
