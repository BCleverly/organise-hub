<?php

use App\Actions\Auth\LogoutUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('logout user action logs out authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    LogoutUser::run();

    $this->assertGuest();
});

test('logout user action invalidates session', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    LogoutUser::run();

    $this->assertGuest();
});
