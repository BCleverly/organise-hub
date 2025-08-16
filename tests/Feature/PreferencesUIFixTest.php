<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('preferences container has correct classes', function () {
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    expect($content)->toContain('preferences-container');
    expect($content)->toContain('max-w-4xl mx-auto');
});

test('preferences page loads with sidebar collapsed', function () {
    $this->user->setPreference('sidebar_collapsed', 'true');
    
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    expect($content)->toContain('sidebar-collapsed');
    expect($content)->toContain('preferences-container');
});

test('preferences page loads with dark theme', function () {
    $this->user->setPreference('theme', 'dark');
    
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    expect($content)->toContain('class="dark"');
    expect($content)->toContain('preferences-container');
});

test('preferences page has dark theme styles', function () {
    $this->user->setPreference('theme', 'dark');
    
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    expect($content)->toContain('bg-white');
    expect($content)->toContain('preferences-container');
});
