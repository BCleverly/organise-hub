<?php

use App\Models\Trackable;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
});



it('shows habits dashboard for authenticated users', function () {
    $this->actingAs($this->user);

    $response = $this->get('/habits');

    $response->assertStatus(200);
    $response->assertSee('Today');
    $response->assertSee('Habits');
    $response->assertSee('Skills');
});

it('shows empty state when no trackables exist', function () {
    $this->actingAs($this->user);

    Livewire::test('Habits')
        ->assertSee('No trackables for today')
        ->assertSee('Create Your First Trackable');
});

it('displays trackables for today', function () {
    $this->actingAs($this->user);

    // Create a daily habit
    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'frequency' => 'daily',
        'goal_metric' => 'checkbox',
    ]);

    // Create a skill
    $skill = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'SKILL',
        'goal_metric' => 'checkbox',
    ]);

    Livewire::test('Habits')
        ->assertSee($habit->title)
        ->assertSee($skill->title)
        ->assertSee('Habits (1)')
        ->assertSee('Skills (1)');
});

it('filters trackables by type', function () {
    $this->actingAs($this->user);

    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'frequency' => 'daily',
    ]);

    $skill = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'SKILL',
    ]);

    Livewire::test('Habits')
        ->set('typeFilter', 'HABIT')
        ->assertSee($habit->title)
        ->assertDontSee($skill->title);

    Livewire::test('Habits')
        ->set('typeFilter', 'SKILL')
        ->assertSee($skill->title)
        ->assertDontSee($habit->title);
});

it('searches trackables by title and description', function () {
    $this->actingAs($this->user);

    $meditationHabit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'title' => 'Morning Meditation',
        'description' => 'Start the day mindfully',
        'frequency' => 'daily',
    ]);

    $readingHabit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'title' => 'Read Books',
        'description' => 'Improve knowledge',
        'frequency' => 'daily',
    ]);

    Livewire::test('Habits')
        ->set('search', 'meditation')
        ->assertSee($meditationHabit->title)
        ->assertDontSee($readingHabit->title);

    Livewire::test('Habits')
        ->set('search', 'knowledge')
        ->assertSee($readingHabit->title)
        ->assertDontSee($meditationHabit->title);
});

it('marks checkbox trackable as completed', function () {
    $this->actingAs($this->user);

    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'goal_metric' => 'checkbox',
        'frequency' => 'daily',
    ]);

    Livewire::test('Habits')
        ->call('markCompleted', $habit->id);

    $this->assertTrue($habit->fresh()->isCompletedToday());
});

it('marks duration trackable as completed', function () {
    $this->actingAs($this->user);

    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'goal_metric' => 'duration',
        'target_duration_minutes' => 30,
        'frequency' => 'daily',
    ]);

    Livewire::test('Habits')
        ->call('markCompleted', $habit->id, 1, 30);

    $this->assertEquals(30, $habit->fresh()->getTodayDuration());
});

it('marks count trackable as completed', function () {
    $this->actingAs($this->user);

    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'goal_metric' => 'count',
        'target_count' => 5,
        'frequency' => 'daily',
    ]);

    Livewire::test('Habits')
        ->call('markCompleted', $habit->id, 5);

    $this->assertEquals(5, $habit->fresh()->getTodayCount());
});

it('marks trackable as incomplete', function () {
    $this->actingAs($this->user);

    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'goal_metric' => 'checkbox',
        'frequency' => 'daily',
    ]);

    // First mark as completed
    $habit->markCompletedToday();

    // Then mark as incomplete
    Livewire::test('Habits')
        ->call('markIncomplete', $habit->id);

    $this->assertFalse($habit->fresh()->isCompletedToday());
});

it('toggles show completed filter', function () {
    $this->actingAs($this->user);

    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'frequency' => 'daily',
    ]);

    $habit->markCompletedToday();

    Livewire::test('Habits')
        ->assertSee($habit->title)
        ->call('toggleShowCompleted')
        ->assertDontSee($habit->title);
});



it('shows correct stats', function () {
    $this->actingAs($this->user);

    // Create some trackables
    Trackable::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'frequency' => 'daily',
    ]);

    Trackable::factory()->count(2)->create([
        'user_id' => $this->user->id,
        'type' => 'SKILL',
    ]);

    // Mark one as completed
    $habit = Trackable::first();
    $habit->markCompletedToday();

    Livewire::test('Habits')
        ->assertSee('5') // Total
        ->assertSee('1') // Completed
        ->assertSee('3') // Habits
        ->assertSee('2'); // Skills
});

it('only shows trackables for the current user', function () {
    $otherUser = User::factory()->create();
    
    $this->actingAs($this->user);

    // Create trackable for current user
    $myHabit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'frequency' => 'daily',
    ]);

    // Create trackable for other user
    $otherHabit = Trackable::factory()->create([
        'user_id' => $otherUser->id,
        'type' => 'HABIT',
        'frequency' => 'daily',
    ]);

    Livewire::test('Habits')
        ->assertSee($myHabit->title)
        ->assertDontSee($otherHabit->title);
});

it('respects frequency settings for habits', function () {
    $this->actingAs($this->user);

    // Create a weekly habit that should only show on Mondays
    $weeklyHabit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'frequency' => 'weekly',
        'frequency_days' => [1], // Monday
    ]);

    // Mock today as Monday
    $this->travelTo(now()->startOfWeek());

    Livewire::test('Habits')
        ->assertSee($weeklyHabit->title);

    // Mock today as Tuesday
    $this->travelTo(now()->startOfWeek()->addDay());

    Livewire::test('Habits')
        ->assertDontSee($weeklyHabit->title);
});

it('shows parent-child relationships', function () {
    $this->actingAs($this->user);

    // Create a skill
    $skill = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'SKILL',
        'title' => 'Learn Guitar',
    ]);

    // Create a habit linked to the skill
    $habit = Trackable::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'HABIT',
        'parent_skill_id' => $skill->id,
        'title' => 'Practice Chords',
        'frequency' => 'daily',
    ]);

    Livewire::test('Habits')
        ->assertSee($skill->title)
        ->assertSee($habit->title);
});

it('can access create habit page', function () {
    $this->actingAs($this->user);

    $response = $this->get('/habits/create');

    $response->assertStatus(200);
    $response->assertSee('What would you like to create?');
});

it('validates form steps correctly', function () {
    $this->actingAs($this->user);

    // Test that we can access the create page
    $response = $this->get('/habits/create');
    $response->assertStatus(200);
    $response->assertSee('What would you like to create?');

    // Test that we can select a type and move to step 2
    Livewire::test('Habits\CreateHabit')
        ->call('selectType', 'HABIT')
        ->assertSet('step', 'habit-config')
        ->assertSee('Configure Your Habit');

    // Test that we can select a goal metric and move to step 3
    Livewire::test('Habits\CreateHabit')
        ->set('type', 'HABIT')
        ->set('step', 'habit-config')
        ->set('title', 'Test Habit')
        ->set('frequency', 'daily')
        ->call('selectGoalMetric', 'checkbox')
        ->assertSet('step', 'goal-config')
        ->assertSee('Set Your Goal');
});


