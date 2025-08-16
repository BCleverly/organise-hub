<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithUserPreferences;
use App\Models\Trackable;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Habits extends Component
{
    use WithUserPreferences;

    public string $search = '';
    public string $typeFilter = '';
    public bool $showCompleted = true;


    /** @var array<string, string> */
    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'showCompleted' => ['except' => true],
    ];

    public function updatingSearch(): void
    {
        // Reset page if using pagination
    }

    public function updatingTypeFilter(): void
    {
        // Reset page if using pagination
    }

    public function toggleShowCompleted(): void
    {
        $this->showCompleted = !$this->showCompleted;
    }

    // Removed modal functionality - now using dedicated create page

    public function markCompleted(int $trackableId, int $count = 1, ?int $durationMinutes = null): void
    {
        $trackable = Trackable::forUser((int) (auth()->id() ?? 0))
            ->findOrFail($trackableId);

        $trackable->markCompletedToday($count, $durationMinutes);

        session()->flash('message', 'Trackable marked as completed!');
    }

    public function markIncomplete(int $trackableId): void
    {
        $trackable = Trackable::forUser((int) (auth()->id() ?? 0))
            ->findOrFail($trackableId);

        $trackable->completions()
            ->where('completed_date', today())
            ->delete();

        // Recalculate streaks
        $trackable->update([
            'current_streak' => $trackable->calculateCurrentStreak(),
        ]);

        session()->flash('message', 'Trackable marked as incomplete!');
    }

    public function mount(): void
    {
        // Load user preferences if needed
        $this->injectUserPreferences();
    }

    public function render(): \Illuminate\View\View
    {
        $query = Trackable::query()
            ->forUser((int) (auth()->id() ?? 0))
            ->active()
            ->with(['completions' => function ($query) {
                $query->where('completed_date', today());
            }, 'parentSkill', 'childHabits', 'todayCompletion'])
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            });

        // Filter by what should be shown today
        $query->forToday();

        $trackables = $query->get();

        // Filter completed items if needed
        if (!$this->showCompleted) {
            $trackables = $trackables->filter(function ($trackable) {
                return !$trackable->isCompletedToday();
            });
        }

        // Group by type for better organization
        $habits = $trackables->where('type', 'HABIT');
        $skills = $trackables->where('type', 'SKILL');

        // Calculate stats
        $stats = [
            'total' => $trackables->count(),
            'completed' => $trackables->filter(fn($t) => $t->isCompletedToday())->count(),
            'habits' => $habits->count(),
            'skills' => $skills->count(),
        ];

        return view('livewire.habits', [
            'habits' => $habits,
            'skills' => $skills,
            'stats' => $stats,
        ])->layout('components.layouts.app');
    }
}
