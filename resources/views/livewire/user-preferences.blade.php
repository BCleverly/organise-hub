<div class="max-w-4xl mx-auto preferences-container">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">User Preferences</h2>
            <p class="text-sm text-gray-600 mt-1">Customise your experience and interface settings</p>
        </div>

        <div class="p-6 space-y-6">
            <!-- Theme Settings -->
            <div>
                <h3 class="text-md font-medium text-gray-900 mb-4">Appearance</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="theme" value="light" class="mr-2">
                                <span class="text-sm text-gray-700">Light</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="theme" value="dark" class="mr-2">
                                <span class="text-sm text-gray-700">Dark</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="theme" value="auto" class="mr-2">
                                <span class="text-sm text-gray-700">Auto (System)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="compactMode" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Compact Mode</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Reduce spacing and padding for a more compact layout</p>
                    </div>
                </div>
            </div>

            <!-- Layout Settings -->
            <div>
                <h3 class="text-md font-medium text-gray-900 mb-4">Layout</h3>
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="sidebarCollapsed" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Collapsed Sidebar</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Start with the sidebar collapsed by default</p>
                    </div>
                </div>
            </div>

            <!-- Task Dashboard Settings -->
            <div>
                <h3 class="text-md font-medium text-gray-900 mb-4">Task Dashboard</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">View Mode</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="taskViewMode" value="detailed" class="mr-2">
                                <span class="text-sm text-gray-700">Detailed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="taskViewMode" value="minimal" class="mr-2">
                                <span class="text-sm text-gray-700">Minimal</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="taskViewMode" value="compact" class="mr-2">
                                <span class="text-sm text-gray-700">Compact</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Choose how much information to display in task cards</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="taskShowOverview" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Show Task Overview</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Display the task statistics and overview section</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="taskShowPriority" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Show Priority Tags</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Display priority indicators on task cards</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="taskShowDueDate" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Show Due Dates</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Display due dates on task cards</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="taskShowDescription" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Show Descriptions</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Display task descriptions on cards</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="taskCollapsedColumns" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Collapsed Columns</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Start with task columns in a collapsed state</p>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div>
                <h3 class="text-md font-medium text-gray-900 mb-4">Notifications</h3>
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="notificationsEnabled" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Enable Browser Notifications</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Receive notifications in your browser for important updates</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="emailNotifications" value="true" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">Email Notifications</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Receive email notifications for important updates</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
            <div class="flex items-center justify-between">
                <p class="text-xs text-gray-500">Your preferences are automatically saved</p>
                <div class="text-xs text-green-600" wire:loading.remove>
                    ✓ Saved
                </div>
                <div class="text-xs text-blue-600" wire:loading>
                    Saving...
                </div>
            </div>
        </div>
    </div>
</div>
