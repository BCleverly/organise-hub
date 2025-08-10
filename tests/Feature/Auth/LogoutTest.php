<?php

use App\Models\User;
use Livewire\Livewire;

test('users can logout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('auth.logout')
        ->call('logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});

test('logout invalidates session', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    Livewire::test('auth.logout')
        ->call('logout');

    $this->assertGuest();
});
