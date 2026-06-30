<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'dob' => '2000-01-01',
            'gender' => 'male',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_duplicate_email_is_rejected()
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'dob' => '2000-01-01',
            'gender' => 'male',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home'));
    }

    public function test_login_fails_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('home'));
    }

    public function test_authenticated_user_cannot_view_login_or_register()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect(route('home'));

        $response = $this->actingAs($user)->get('/register');
        $response->assertRedirect(route('home'));
    }
}
