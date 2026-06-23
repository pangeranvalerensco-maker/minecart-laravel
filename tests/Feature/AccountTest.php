<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_account_page()
    {
        $response = $this->get('/account');
        $response->assertRedirect('/login');
    }

    public function test_user_can_access_account_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/account');

        $response->assertStatus(200);
        $response->assertViewIs('account.index');
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/account', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Test 123',
            'city' => 'Jakarta',
            'postal_code' => '12345',
        ]);

        $response->assertRedirect(route('account.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Test 123',
            'city' => 'Jakarta',
            'postal_code' => '12345',
        ]);
    }

    public function test_user_can_keep_same_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($user)->patch('/account', [
            'name' => 'Updated Name',
            'email' => 'test@example.com', // same email
        ]);

        $response->assertRedirect(route('account.index'));
        $response->assertSessionHasNoErrors();
    }

    public function test_user_cannot_use_email_owned_by_another()
    {
        User::factory()->create([
            'email' => 'other@example.com',
        ]);

        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($user)->patch('/account', [
            'name' => 'Updated Name',
            'email' => 'other@example.com', // owned by another
        ]);

        $response->assertSessionHasErrors('email');
    }
}
