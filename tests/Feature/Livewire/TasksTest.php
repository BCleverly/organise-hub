<?php

use App\Livewire\Tasks;
use App\Models\Task;
use App\Models\User;

test('tasks component can be rendered', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->assertStatus(200);
});

test('tasks shows task manager title', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->assertSee('Task Manager');
});

test('tasks requires authentication', function () {
    $response = $this->get('/tasks');
    $response->assertRedirect('/login');
});

test('user can only see their own tasks', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $task1 = Task::factory()->create(['user_id' => $user1->id]);
    $task2 = Task::factory()->create(['user_id' => $user2->id]);

    Livewire::actingAs($user1)
        ->test(Tasks::class)
        ->assertSee($task1->title)
        ->assertDontSee($task2->title);
});

test('tasks are grouped by status', function () {
    $user = User::factory()->create();

    $todoTask = Task::factory()->create([
        'user_id' => $user->id,
        'status' => 'todo',
        'title' => 'Todo Task',
    ]);

    $completedTask = Task::factory()->create([
        'user_id' => $user->id,
        'status' => 'completed',
        'title' => 'Completed Task',
    ]);

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->assertSee('Todo Task')
        ->assertSee('Completed Task');
});

test('search functionality works', function () {
    $user = User::factory()->create();

    $task1 = Task::factory()->create([
        'user_id' => $user->id,
        'title' => 'Important meeting',
    ]);

    $task2 = Task::factory()->create([
        'user_id' => $user->id,
        'title' => 'Buy groceries',
    ]);

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->set('search', 'meeting')
        ->assertSee('Important meeting')
        ->assertDontSee('Buy groceries');
});

test('task statistics are correct', function () {
    $user = User::factory()->create();

    Task::factory()->count(3)->create([
        'user_id' => $user->id,
        'status' => 'completed',
    ]);

    Task::factory()->count(2)->create([
        'user_id' => $user->id,
        'status' => 'in_progress',
    ]);

    Task::factory()->count(1)->create([
        'user_id' => $user->id,
        'status' => 'todo',
    ]);

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->assertSee('6') // Total tasks
        ->assertSee('3') // Completed tasks
        ->assertSee('2') // In progress tasks
        ->assertSee('1'); // Pending tasks (todo + awaiting)
});

test('tasks can have tags', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $task->attachTag('urgent');
    $task->attachTag('work');

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->assertSee('urgent')
        ->assertSee('work');
});

test('empty state is shown when no tasks', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Tasks::class)
        ->assertSee('No tasks in this column');
});
