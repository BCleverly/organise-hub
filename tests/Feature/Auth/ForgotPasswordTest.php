<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
    ]);
});

test('forgot password page can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('password reset link can be requested', function () {
    Livewire::test('auth.forgot-password')
        ->set('email', 'test@example.com')
        ->call('sendResetLink')
        ->assertSet('emailSent', true);
});

test('email is required', function () {
    Livewire::test('auth.forgot-password')
        ->call('sendResetLink')
        ->assertHasErrors(['email' => 'required']);
});

test('email must be valid email format', function () {
    Livewire::test('auth.forgot-password')
        ->set('email', 'not-an-email')
        ->call('sendResetLink')
        ->assertHasErrors(['email' => 'email']);
});

test('authenticated users are redirected to dashboard', function () {
    $this->actingAs($this->user);

    $response = $this->get('/forgot-password');

    $response->assertRedirect('/dashboard');
});
