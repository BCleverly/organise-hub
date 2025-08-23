<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectUserPreferences
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Always provide default preferences, even for guests
        $preferences = [
            'theme' => 'light',
            'sidebarCollapsed' => 'false',
            'compactMode' => 'false',
            'notificationsEnabled' => 'true',
            'emailNotifications' => 'true',

            // Task-specific UI preferences
            'taskViewMode' => 'detailed',
            'taskShowOverview' => 'true',
            'taskShowPriority' => 'true',
            'taskShowDueDate' => 'true',
            'taskShowDescription' => 'true',
            'taskCollapsedColumns' => 'false',
        ];

        // Override with user preferences if authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $preferences = [
                'theme' => $user->getPreference('theme', 'light'),
                'sidebarCollapsed' => $this->normalizeBooleanPreference($user->getPreference('sidebar_collapsed', 'false')),
                'compactMode' => $this->normalizeBooleanPreference($user->getPreference('compact_mode', 'false')),
                'notificationsEnabled' => $this->normalizeBooleanPreference($user->getPreference('notifications_enabled', 'true')),
                'emailNotifications' => $this->normalizeBooleanPreference($user->getPreference('email_notifications', 'true')),

                // Task-specific UI preferences
                'taskViewMode' => $user->getPreference('task_view_mode', 'detailed'),
                'taskShowOverview' => $this->normalizeBooleanPreference($user->getPreference('task_show_overview', 'true')),
                'taskShowPriority' => $this->normalizeBooleanPreference($user->getPreference('task_show_priority', 'true')),
                'taskShowDueDate' => $this->normalizeBooleanPreference($user->getPreference('task_show_due_date', 'true')),
                'taskShowDescription' => $this->normalizeBooleanPreference($user->getPreference('task_show_description', 'true')),
                'taskCollapsedColumns' => $this->normalizeBooleanPreference($user->getPreference('task_collapsed_columns', 'false')),
            ];
        }

        view()->share('userPreferences', $preferences);

        return $next($request);
    }

    private function normalizeBooleanPreference(string $value): string
    {
        return in_array($value, ['true', '1', 'on'], true) ? 'true' : 'false';
    }
}
