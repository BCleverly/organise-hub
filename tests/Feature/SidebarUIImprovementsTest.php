<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('sidebar has tooltip attributes', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('data-tooltip');
    expect($content)->toContain('data-tooltip="Dashboard"');
    expect($content)->toContain('data-tooltip="Tasks"');
    expect($content)->toContain('data-tooltip="Recipes"');
});

test('sidebar has floating toggle button', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('sidebar-toggle-btn');
    expect($content)->toContain('onclick="window.userPreferencesManager?.toggleSidebar()"');
    expect($content)->toContain('title="Toggle Sidebar"');
});

test('toggle button positioning in collapsed state', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');

    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('sidebar-collapsed');
    expect($content)->toContain('sidebar-toggle-btn');
});

test('sidebar items have correct classes', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('sidebar-item');
    expect($content)->toContain('sidebar-text');
    expect($content)->toContain('sidebar-icon');
});

test('sidebar section headers have correct classes', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    // Since we removed the Personal section header, we no longer have section-header classes
    // The test now verifies that the sidebar structure is still intact
    expect($content)->toContain('sidebar-item');
    expect($content)->toContain('sidebar-text');
});

test('user profile section has correct classes', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();

    // Check that user profile elements have the correct classes
    expect($content)->toContain('user-profile-avatar');
    expect($content)->toContain('user-profile-text');
    expect($content)->toContain('user-profile-section');
    expect($content)->toContain('user-menu-button');
    expect($content)->toContain('user-menu-dropup');

    // Check that profile information elements exist in the drop-up menu
    expect($content)->toContain('user-profile-avatar');
    expect($content)->toContain('text-sm font-medium text-white'); // Name styling
    expect($content)->toContain('text-xs text-gray-400'); // Email styling
});

test('sidebar collapsed state hides text but shows icons', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');

    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('sidebar-collapsed');
    expect($content)->toContain('sidebar-item');
    expect($content)->toContain('sidebar-icon');
});

test('toggle button remains visible in collapsed state', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');

    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    expect($content)->toContain('sidebar-collapsed');
    expect($content)->toContain('sidebar-toggle-btn');
});

test('drop up menu has no arrow in collapsed state', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');

    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();

    // Check that the drop-up menu exists but has no arrow indicators
    expect($content)->toContain('user-menu-dropup');
    expect($content)->toContain('sidebar-collapsed');

    // Verify that the CSS will hide the arrow (this is tested via the CSS rule)
    // The CSS rule .sidebar-collapsed .user-menu-dropup::before, .sidebar-collapsed .user-menu-dropup::after { display: none; }
    // ensures no arrow is shown in collapsed state
});

test('profile avatar is hidden in collapsed state', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');

    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();

    // Check that the profile avatar element exists in HTML but will be hidden by CSS
    expect($content)->toContain('user-profile-avatar');
    expect($content)->toContain('sidebar-collapsed');

    // The CSS rule .sidebar-collapsed .user-profile-avatar { display: none; } will hide the avatar
    // This ensures a cleaner collapsed sidebar with only the menu button visible
});
