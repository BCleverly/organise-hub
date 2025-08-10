<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);
});

test('login page can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login form', function () {
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('users can authenticate with remember me', function () {
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('remember', true)
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('users cannot authenticate with invalid password', function () {
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();
});

test('users cannot authenticate with invalid email', function () {
    Livewire::test('auth.login')
        ->set('email', 'wrong@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();
});

test('email is required', function () {
    Livewire::test('auth.login')
        ->set('password', 'password123')
        ->call('login')
        ->assertHasErrors(['email' => 'required']);
});

test('password is required', function () {
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->call('login')
        ->assertHasErrors(['password' => 'required']);
});

test('email must be valid email format', function () {
    Livewire::test('auth.login')
        ->set('email', 'not-an-email')
        ->set('password', 'password123')
        ->call('login')
        ->assertHasErrors(['email' => 'email']);
});

test('authenticated users are redirected to dashboard', function () {
    $this->actingAs($this->user);

    $response = $this->get('/login');

    $response->assertRedirect('/dashboard');
});
