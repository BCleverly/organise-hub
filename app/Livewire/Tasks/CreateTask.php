<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CreateTask extends Component
{
    public string $title = '';

    public string $description = '';

    public string $status = 'todo';

    public string $priority = 'medium';

    public ?string $due_date = null;

    public function mount(): void
    {
        // Get status from query parameter if provided
        if (request()->has('status')) {
            $status = request()->get('status');
            if (in_array($status, ['todo', 'in_progress', 'awaiting', 'completed'])) {
                $this->status = $status;
            }
        }
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:todo,in_progress,awaiting,completed',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
    ];

    public function save(): void
    {
        $this->authorize('create', Task::class);
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date ? \Carbon\Carbon::parse($this->due_date) : null,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Task created successfully!');

        $this->redirect(route('tasks'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.tasks.create-task');
    }
}
