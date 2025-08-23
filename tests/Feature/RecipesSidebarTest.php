<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('recipes page respects sidebar collapsed preference', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');
    $this->user->refresh();

    $response = $this->get('/recipes');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('sidebar-collapsed');
    expect($content)->toContain('window.userPreferences');
    expect($content)->toContain('sidebar-toggle-btn');
});

test('recipes page respects sidebar expanded preference', function () {
    $this->user->setPreference('sidebar_collapsed', 'false');
    $this->user->refresh();

    $response = $this->get('/recipes');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->not->toMatch('/class="[^"]*sidebar-collapsed[^"]*"/');
    expect($content)->toContain('window.userPreferences');
});

test('recipes page injects user preferences', function () {
    $this->user->setPreference('theme', 'dark');
    $this->user->setPreference('sidebar_collapsed', 'true');
    $this->user->setPreference('compact_mode', 'true');

    $response = $this->get('/recipes');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('"theme":"dark"');
    expect($content)->toContain('"sidebarCollapsed":"true"');
    expect($content)->toContain('"compactMode":"true"');
});
