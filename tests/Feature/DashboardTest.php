<?php

use App\Models\User;

test('dashboard can be accessed by authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Welcome to OrganizeHub!');
    $response->assertSee('Today\'s Focus', false);
    $response->assertSee('Quick Actions');
    $response->assertSee('Add Task');
    $response->assertSee('Add Recipe');
});

test('dashboard redirects unauthenticated users to login', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});
