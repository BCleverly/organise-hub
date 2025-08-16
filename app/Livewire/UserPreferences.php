<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithUserPreferences;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.app')]
class UserPreferences extends Component
{
    use WithUserPreferences;
    public string $theme = 'light';
    public string $sidebarCollapsed = 'false';
    public string $compactMode = 'false';
    public string $notificationsEnabled = 'true';
    public string $emailNotifications = 'true';
    
    // Task-specific UI preferences
    public string $taskViewMode = 'detailed';
    public string $taskShowOverview = 'true';
    public string $taskShowPriority = 'true';
    public string $taskShowDueDate = 'true';
    public string $taskShowDescription = 'true';
    public string $taskCollapsedColumns = 'false';

    public function mount(): void
    {
        $user = auth()->user();
        
        if ($user) {
            $this->theme = $user->getPreference('theme', 'light');
            $this->sidebarCollapsed = $this->normalizeBooleanPreference($user->getPreference('sidebar_collapsed', 'false'));
            $this->compactMode = $this->normalizeBooleanPreference($user->getPreference('compact_mode', 'false'));
            $this->notificationsEnabled = $this->normalizeBooleanPreference($user->getPreference('notifications_enabled', 'true'));
            $this->emailNotifications = $this->normalizeBooleanPreference($user->getPreference('email_notifications', 'true'));
            
            // Load task-specific preferences
            $this->taskViewMode = $user->getPreference('task_view_mode', 'detailed');
            $this->taskShowOverview = $this->normalizeBooleanPreference($user->getPreference('task_show_overview', 'true'));
            $this->taskShowPriority = $this->normalizeBooleanPreference($user->getPreference('task_show_priority', 'true'));
            $this->taskShowDueDate = $this->normalizeBooleanPreference($user->getPreference('task_show_due_date', 'true'));
            $this->taskShowDescription = $this->normalizeBooleanPreference($user->getPreference('task_show_description', 'true'));
            $this->taskCollapsedColumns = $this->normalizeBooleanPreference($user->getPreference('task_collapsed_columns', 'false'));
        }
    }

    private function normalizeBooleanPreference(string $value): string
    {
        return in_array($value, ['true', '1', 'on'], true) ? 'true' : 'false';
    }

    public function updatedTheme(): void
    {
        $this->savePreference('theme', $this->theme);
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function updatedSidebarCollapsed(): void
    {
        $this->savePreference('sidebar_collapsed', $this->sidebarCollapsed);
        $this->dispatch('sidebar-toggled', collapsed: $this->sidebarCollapsed === 'true');
    }

    #[On('sidebar-toggled')]
    public function handleSidebarToggle($collapsed): void
    {
        $this->sidebarCollapsed = $collapsed ? 'true' : 'false';
        $this->savePreference('sidebar_collapsed', $this->sidebarCollapsed);
    }

    #[On('task-view-mode-changed')]
    public function handleTaskViewModeChanged($mode): void
    {
        $this->taskViewMode = $mode;
        $this->savePreference('task_view_mode', $this->taskViewMode);
    }

    #[On('task-overview-toggled')]
    public function handleTaskOverviewToggled($visible): void
    {
        $this->taskShowOverview = $visible ? 'true' : 'false';
        $this->savePreference('task_show_overview', $this->taskShowOverview);
    }

    public function updatedCompactMode(): void
    {
        $this->savePreference('compact_mode', $this->compactMode);
        $this->dispatch('compact-mode-toggled', enabled: $this->compactMode === 'true');
    }

    public function updatedNotificationsEnabled(): void
    {
        $this->savePreference('notifications_enabled', $this->notificationsEnabled);
    }

    public function updatedEmailNotifications(): void
    {
        $this->savePreference('email_notifications', $this->emailNotifications);
    }

    // Task-specific preference update methods
    public function updatedTaskViewMode(): void
    {
        $this->savePreference('task_view_mode', $this->taskViewMode);
        $this->dispatch('task-view-mode-changed', mode: $this->taskViewMode);
    }

    public function updatedTaskShowOverview(): void
    {
        $this->savePreference('task_show_overview', $this->taskShowOverview);
        $this->dispatch('task-overview-toggled', visible: $this->taskShowOverview === 'true');
    }

    public function updatedTaskShowPriority(): void
    {
        $this->savePreference('task_show_priority', $this->taskShowPriority);
        $this->dispatch('task-priority-toggled', visible: $this->taskShowPriority === 'true');
    }

    public function updatedTaskShowDueDate(): void
    {
        $this->savePreference('task_show_due_date', $this->taskShowDueDate);
        $this->dispatch('task-due-date-toggled', visible: $this->taskShowDueDate === 'true');
    }

    public function updatedTaskShowDescription(): void
    {
        $this->savePreference('task_show_description', $this->taskShowDescription);
        $this->dispatch('task-description-toggled', visible: $this->taskShowDescription === 'true');
    }

    public function updatedTaskCollapsedColumns(): void
    {
        $this->savePreference('task_collapsed_columns', $this->taskCollapsedColumns);
        $this->dispatch('task-columns-toggled', collapsed: $this->taskCollapsedColumns === 'true');
    }

    private function savePreference(string $key, string $value): void
    {
        $user = auth()->user();
        if ($user) {
            $user->setPreference($key, $value);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $this->injectUserPreferences();
        
        return view('livewire.user-preferences');
    }
}
