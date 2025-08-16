<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithUserPreferences;
use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Tasks extends Component
{
    use WithPagination, WithUserPreferences;

    public string $search = '';

    public string $statusFilter = '';

    public string $priorityFilter = '';

    /** @var array<int, string> */
    public array $tagFilters = [];

    public string $viewMode = 'detailed'; // 'detailed', 'minimal', or 'compact'

    public bool $showOverview = true;

    /** @var array<string, array<string, string>> */
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
        'tagFilters' => ['except' => []],
        'viewMode' => ['except' => 'detailed'],
        'showOverview' => ['except' => true],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPriorityFilter(): void
    {
        $this->resetPage();
    }

    public function updatingTagFilters(): void
    {
        $this->resetPage();
    }

    public function updatingViewMode(): void
    {
        $this->resetPage();

        // Save the view mode preference to global user preferences
        $user = auth()->user();
        if ($user) {
            $user->setPreference('task_view_mode', $this->viewMode);
        }
    }

    public function updatedViewMode(): void
    {
        // Save the view mode preference to global user preferences
        $user = auth()->user();
        if ($user) {
            $user->setPreference('task_view_mode', $this->viewMode);

            // Dispatch Livewire event for global preferences system
            $this->dispatch('task-view-mode-changed', mode: $this->viewMode);
        }
    }

    public function updatedShowOverview(): void
    {
        // Save the overview preference to global user preferences
        $user = auth()->user();
        if ($user) {
            $user->setPreference('task_show_overview', $this->showOverview ? 'true' : 'false');

            // Dispatch Livewire event for global preferences system
            $this->dispatch('task-overview-toggled', visible: $this->showOverview);
        }
    }

    public function mount(): void
    {
        $user = auth()->user();

        if ($user) {
            // Load user preferences for task view
            $this->viewMode = $user->getPreference('task_view_mode', 'detailed');
            $this->showOverview = $this->normalizeBooleanPreference($user->getPreference('task_show_overview', 'true')) === 'true';
        }
    }

    private function normalizeBooleanPreference(string $value): string
    {
        return in_array($value, ['true', '1', 'on'], true) ? 'true' : 'false';
    }

    /**
     * Get all available tags for the current user's tasks.
     */
    public function getAvailableTags(): \Illuminate\Support\Collection
    {
        return Task::forUser((int) (auth()->id() ?? 0))
            ->with('tags')
            ->get()
            ->flatMap(function ($task) {
                return $task->tags;
            })
            ->unique('id')
            ->sortBy('name');
    }

    /**
     * Clear all filters.
     */
    public function clearFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'priorityFilter', 'tagFilters']);
    }

    /**
     * Add a tag to the filter.
     */
    public function addTagFilter(string $tag): void
    {
        if (! in_array($tag, $this->tagFilters)) {
            $this->tagFilters[] = $tag;
        }
    }

    /**
     * Remove a tag from the filter.
     */
    public function removeTagFilter(string $tag): void
    {
        $this->tagFilters = array_values(array_filter($this->tagFilters, fn ($t) => $t !== $tag));
    }

    public function moveTask(int $taskId, string $newStatus): void
    {
        $task = Task::forUser((int) (auth()->id() ?? 0))->findOrFail($taskId);

        $task->update(['status' => $newStatus]);

        session()->flash('message', 'Task moved successfully!');
    }

    public function updateTaskStatus(int $taskId, string $newStatus): void
    {
        $task = Task::forUser((int) (auth()->id() ?? 0))->findOrFail($taskId);

        $task->update(['status' => $newStatus]);

        session()->flash('message', 'Task moved successfully!');
    }

    public function render(): \Illuminate\View\View
    {
        // Inject user preferences
        $this->injectUserPreferences();

        $tasks = Task::query()
            ->forUser((int) (auth()->id() ?? 0))
            ->with('tags') // Eager load the tags relationship
            ->when($this->search, function ($query) {
                $searchTerm = '%'.$this->search.'%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->withStatus($this->statusFilter);
            })
            ->when($this->priorityFilter, function ($query) {
                $query->withPriority($this->priorityFilter);
            })
            ->when($this->tagFilters, function ($query) {
                $query->withAnyTags($this->tagFilters);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        $taskStats = [
            'total' => Task::forUser((int) (auth()->id() ?? 0))->count(),
            'completed' => Task::forUser((int) (auth()->id() ?? 0))->withStatus('completed')->count(),
            'in_progress' => Task::forUser((int) (auth()->id() ?? 0))->withStatus('in_progress')->count(),
            'pending' => Task::forUser((int) (auth()->id() ?? 0))->whereIn('status', ['todo', 'awaiting'])->count(),
        ];

        return view('livewire.tasks', [
            'tasks' => $tasks,
            'taskStats' => $taskStats,
            'availableTags' => $this->getAvailableTags(),
        ])->layout('components.layouts.app');
    }
}
