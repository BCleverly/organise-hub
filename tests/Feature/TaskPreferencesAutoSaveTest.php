<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('task view mode is automatically saved to global preferences', function () {
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('viewMode', 'minimal')
        ->assertSet('viewMode', 'minimal');
    
    $this->user->refresh();
    expect($this->user->getPreference('task_view_mode'))->toBe('minimal');
    
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('viewMode', 'detailed')
        ->assertSet('viewMode', 'detailed');
    
    $this->user->refresh();
    expect($this->user->getPreference('task_view_mode'))->toBe('detailed');
});

test('task overview toggle is automatically saved to global preferences', function () {
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('showOverview', false)
        ->assertSet('showOverview', false);
    
    $this->user->refresh();
    expect($this->user->getPreference('task_show_overview'))->toBe('false');
    
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('showOverview', true)
        ->assertSet('showOverview', true);
    
    $this->user->refresh();
    expect($this->user->getPreference('task_show_overview'))->toBe('true');
});

test('task preferences persist across page navigation', function () {
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('viewMode', 'minimal')
        ->set('showOverview', false);
    
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    expect($content)->toContain('value="minimal"');
    expect($content)->toContain('taskShowOverview'); // Checkbox element exists
    expect($content)->toContain('Show Task Overview'); // Label text exists
});

test('task preferences are loaded on tasks page refresh', function () {
    $this->user->setPreference('task_view_mode', 'minimal');
    $this->user->setPreference('task_show_overview', 'false');
    
    Livewire::test(\App\Livewire\Tasks::class)
        ->assertSet('viewMode', 'minimal')
        ->assertSet('showOverview', false);
});

test('livewire events are dispatched when preferences change', function () {
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('viewMode', 'minimal')
        ->assertDispatched('task-view-mode-changed', mode: 'minimal');
    
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('showOverview', false)
        ->assertDispatched('task-overview-toggled', visible: false);
});
