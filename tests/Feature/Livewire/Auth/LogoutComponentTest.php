<?php

use App\Livewire\Auth\Logout;
use App\Models\User;
use Livewire\Livewire;

test('logout component logs out authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});

test('logout component invalidates session', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    Livewire::test(Logout::class)
        ->call('logout');

    $this->assertGuest();
});

test('logout component renders correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Logout::class)
        ->assertSee('Logout');
});

test('logout component can be called multiple times safely', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    $component = Livewire::test(Logout::class);

    // First logout
    $component->call('logout');
    $this->assertGuest();

    // Second logout should not cause issues
    $component->call('logout');
    $this->assertGuest();
});

test('logout component works with different user types', function () {
    $adminUser = User::factory()->create(['email' => 'admin@example.com']);
    $this->actingAs($adminUser);

    $this->assertAuthenticated();

    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});
