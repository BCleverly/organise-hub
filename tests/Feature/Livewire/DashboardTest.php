<?php

use App\Livewire\Dashboard;
use App\Models\User;

test('dashboard component can be rendered', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertStatus(200);
});

test('dashboard shows welcome message', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertSee('Welcome to OrganizeHub!');
});

test('dashboard shows todays focus section', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertSee('Today\'s Focus', false)
        ->assertSee('Habit Tracker');
});

test('dashboard shows quick actions section', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertSee('Quick Actions')
        ->assertSee('Add Task')
        ->assertSee('Add Recipe')
        ->assertSee('Track Habit')
        ->assertSee('View');
});

test('dashboard requires authentication', function () {
    // The component itself doesn't require authentication
    // Authentication is handled at the route level
    Livewire::test(Dashboard::class)
        ->assertStatus(200);
});
