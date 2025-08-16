<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuickLoginIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_quick_login_feature_is_available_in_development(): void
    {
        // Create test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Visit login page
        $response = $this->get('/login');

        // Should see the quick login section in development/testing
        $response->assertSee('Development Quick Login');
        $response->assertSee('Login as Test User');
        $response->assertSee('Login as Admin');
        $response->assertSee('test@example.com');
        $response->assertSee('admin@example.com');
    }

    public function test_quick_login_buttons_are_present(): void
    {
        // Visit login page
        $response = $this->get('/login');

        // Should see the quick login buttons (without escaping)
        $response->assertSee('wire:click="quickLogin(\'test@example.com\')"', false);
        $response->assertSee('wire:click="quickLogin(\'admin@example.com\')"', false);
    }
}
