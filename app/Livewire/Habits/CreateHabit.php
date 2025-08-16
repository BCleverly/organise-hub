<?php

namespace App\Livewire\Habits;

use App\Models\Trackable;
use Livewire\Component;
use Livewire\Attributes\Rule;

class CreateHabit extends Component
{
    #[Rule('required|string|max:255')]
    public string $title = '';

    #[Rule('nullable|string|max:1000')]
    public ?string $description = null;

    #[Rule('required|in:HABIT,SKILL')]
    public string $type = 'HABIT';

    #[Rule('required|in:checkbox,duration,count')]
    public string $goalMetric = 'checkbox';

    #[Rule('nullable|exists:trackables,id')]
    public ?int $parentSkillId = null;

    #[Rule('nullable|string|in:daily,weekly,monthly')]
    public ?string $frequency = null;

    #[Rule('nullable|array')]
    public array $frequencyDays = [];

    #[Rule('nullable|integer|min:1')]
    public ?int $targetCount = null;

    #[Rule('nullable|integer|min:1')]
    public ?int $targetDurationMinutes = null;

    #[Rule('nullable|date|after:today')]
    public ?string $targetCompletionDate = null;

    public string $step = 'type';

    public function mount(): void
    {
        // Initialize with default values
    }

    public function selectType(string $type): void
    {
        $this->type = $type;
        $this->step = $type === 'HABIT' ? 'habit-config' : 'skill-config';
    }

    public function selectGoalMetric(string $goalMetric): void
    {
        $this->goalMetric = $goalMetric;
        $this->step = 'goal-config';
    }

    public function backToType(): void
    {
        $this->step = 'type';
        $this->reset(['type', 'goalMetric', 'frequency', 'frequencyDays', 'targetCount', 'targetDurationMinutes', 'targetCompletionDate']);
    }

    public function backToConfig(): void
    {
        $this->step = $this->type === 'HABIT' ? 'habit-config' : 'skill-config';
        $this->reset(['goalMetric', 'targetCount', 'targetDurationMinutes']);
    }

    public function toggleFrequencyDay(int $day): void
    {
        if (in_array($day, $this->frequencyDays)) {
            $this->frequencyDays = array_values(array_filter($this->frequencyDays, fn($d) => $d !== $day));
        } else {
            $this->frequencyDays[] = $day;
            sort($this->frequencyDays);
        }
    }

    public function save(): void
    {
        $this->validate();

        $trackable = Trackable::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'goal_metric' => $this->goalMetric,
            'parent_skill_id' => $this->parentSkillId,
            'frequency' => $this->frequency,
            'frequency_days' => !empty($this->frequencyDays) ? $this->frequencyDays : null,
            'target_count' => $this->targetCount,
            'target_duration_minutes' => $this->targetDurationMinutes,
            'target_completion_date' => $this->targetCompletionDate,
        ]);

        session()->flash('message', ucfirst(strtolower($this->type)) . ' created successfully!');

        $this->redirect(route('habits'));
    }

    public function getAvailableSkillsProperty()
    {
        return Trackable::forUser((int) (auth()->id() ?? 0))
            ->skills()
            ->active()
            ->get();
    }

    public function getWeekDaysProperty()
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];
    }

    public function getMonthDaysProperty()
    {
        return collect(range(1, 31))->mapWithKeys(fn($day) => [$day => $day]);
    }

    public function render()
    {
        return view('livewire.habits.create-habit')
            ->layout('components.layouts.app');
    }
}
