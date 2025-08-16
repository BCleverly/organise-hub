<?php

namespace App\View\Components;

use App\Models\Trackable;
use Illuminate\View\Component;

class TrackableCard extends Component
{
    public function __construct(
        public Trackable $trackable,
        public bool $showProgress = true,
        public string $viewMode = 'default'
    ) {}

    public function render(): \Illuminate\View\View
    {
        return view('components.trackable-card');
    }

    /**
     * Get the appropriate icon for the trackable type.
     */
    public function getTypeIcon(): string
    {
        return match ($this->trackable->type) {
            'HABIT' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'SKILL' => 'M13 10V3L4 14h7v7l9-11h-7z',
            default => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        };
    }

    /**
     * Get the appropriate color classes for the trackable type.
     */
    public function getTypeColors(): array
    {
        return match ($this->trackable->type) {
            'HABIT' => [
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-600',
                'border' => 'border-blue-200',
                'hover' => 'hover:bg-blue-100',
            ],
            'SKILL' => [
                'bg' => 'bg-purple-50',
                'text' => 'text-purple-600',
                'border' => 'border-purple-200',
                'hover' => 'hover:bg-purple-100',
            ],
            default => [
                'bg' => 'bg-gray-50',
                'text' => 'text-gray-600',
                'border' => 'border-gray-200',
                'hover' => 'hover:bg-gray-100',
            ],
        };
    }

    /**
     * Get the completion status color.
     */
    public function getCompletionColor(): string
    {
        if ($this->trackable->isCompletedToday()) {
            return 'text-green-600 bg-green-50 border-green-200';
        }

        return 'text-gray-600 bg-gray-50 border-gray-200';
    }

    /**
     * Get the progress percentage for skills.
     */
    public function getProgressPercentage(): int
    {
        if ($this->trackable->type !== 'SKILL') {
            return 0;
        }

        return $this->trackable->progress_percentage;
    }

    /**
     * Get the progress color based on percentage.
     */
    public function getProgressColor(): string
    {
        $percentage = $this->getProgressPercentage();
        
        return match (true) {
            $percentage >= 80 => 'bg-green-500',
            $percentage >= 60 => 'bg-blue-500',
            $percentage >= 40 => 'bg-yellow-500',
            $percentage >= 20 => 'bg-orange-500',
            default => 'bg-red-500',
        };
    }
}
