<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class EditTask extends Component
{
    public Task $task;
    public string $title = '';
    public string $description = '';
    public string $status = 'todo';
    public string $priority = 'medium';
    public ?string $due_date = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:todo,in_progress,awaiting,completed',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
    ];

    public function mount(Task $task): void
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description ?? '';
        $this->status = $task->status;
        $this->priority = $task->priority;
        $this->due_date = $task->due_date?->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date ? \Carbon\Carbon::parse($this->due_date) : null,
        ]);

        session()->flash('message', 'Task updated successfully!');

        $this->redirect(route('tasks'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.tasks.edit-task');
    }
}
