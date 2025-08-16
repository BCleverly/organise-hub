// User Preferences Management
class UserPreferences {
    constructor() {
        this.preferences = this.loadPreferences();
        this.applyPreferences();
        this.setupEventListeners();
    }

    loadPreferences() {
        // Load preferences from server-side data
        const userPreferences = window.userPreferences || {};
        
        // Helper function to normalize boolean values
        const normalizeBoolean = (value) => {
            if (typeof value === 'boolean') return value;
            if (typeof value === 'string') {
                return value === 'true' || value === '1' || value === 'on';
            }
            return false;
        };
        
        return {
            theme: userPreferences.theme || 'light',
            sidebarCollapsed: normalizeBoolean(userPreferences.sidebarCollapsed),
            compactMode: normalizeBoolean(userPreferences.compactMode),
            notificationsEnabled: normalizeBoolean(userPreferences.notificationsEnabled),
            emailNotifications: normalizeBoolean(userPreferences.emailNotifications),
            
            // Task-specific preferences
            taskViewMode: userPreferences.taskViewMode || 'detailed',
            taskShowOverview: normalizeBoolean(userPreferences.taskShowOverview),
            taskShowPriority: normalizeBoolean(userPreferences.taskShowPriority),
            taskShowDueDate: normalizeBoolean(userPreferences.taskShowDueDate),
            taskShowDescription: normalizeBoolean(userPreferences.taskShowDescription),
            taskCollapsedColumns: normalizeBoolean(userPreferences.taskCollapsedColumns)
        };
    }

    applyPreferences() {
        this.applyTheme();
        this.applyLayout();
        this.applyTaskPreferences();
    }

    applyTheme() {
        const theme = this.preferences.theme;
        const html = document.documentElement;
        
        // Remove existing theme classes
        html.classList.remove('light', 'dark');
        
        if (theme === 'auto') {
            // Check system preference
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            html.classList.add(systemTheme);
        } else {
            html.classList.add(theme);
        }
    }

    applyLayout() {
        if (this.preferences.compactMode) {
            document.body.classList.add('compact-mode');
        } else {
            document.body.classList.remove('compact-mode');
        }

        if (this.preferences.sidebarCollapsed) {
            document.body.classList.add('sidebar-collapsed');
        } else {
            document.body.classList.remove('sidebar-collapsed');
        }

        // Update preferences container if it exists
        this.updatePreferencesContainer();
        
        // Update toggle button state
        this.updateToggleButton();
    }

    updatePreferencesContainer() {
        const preferencesContainer = document.querySelector('.preferences-container');
        if (preferencesContainer) {
            if (this.preferences.sidebarCollapsed) {
                preferencesContainer.style.maxWidth = '72rem';
                preferencesContainer.style.marginLeft = '2rem';
                preferencesContainer.style.marginRight = '2rem';
            } else {
                preferencesContainer.style.maxWidth = '56rem'; // 4xl
                preferencesContainer.style.marginLeft = 'auto';
                preferencesContainer.style.marginRight = 'auto';
            }
        }
    }

    updateToggleButton() {
        const toggleBtn = document.querySelector('.sidebar-toggle-btn');
        if (toggleBtn) {
            const arrow = toggleBtn.querySelector('svg');
            if (arrow) {
                if (this.preferences.sidebarCollapsed) {
                    arrow.style.transform = 'rotate(180deg)';
                    toggleBtn.style.right = '-6px';
                } else {
                    arrow.style.transform = 'rotate(0deg)';
                    toggleBtn.style.right = '-3px';
                }
            }
        }
    }

    applyTaskPreferences() {
        // Apply task-specific preferences
        const taskContainer = document.querySelector('[data-task-container]');
        if (taskContainer) {
            // Apply view mode
            taskContainer.setAttribute('data-view-mode', this.preferences.taskViewMode);
            
            // Apply overview visibility
            const overview = document.querySelector('[data-task-overview]');
            if (overview) {
                if (this.preferences.taskShowOverview) {
                    overview.style.display = 'block';
                } else {
                    overview.style.display = 'none';
                }
            }
            
            // Apply column collapsed state
            const columns = document.querySelectorAll('[data-task-column]');
            columns.forEach(column => {
                if (this.preferences.taskCollapsedColumns) {
                    column.classList.add('collapsed');
                } else {
                    column.classList.remove('collapsed');
                }
            });
        }
    }

    setupEventListeners() {
        // Listen for Livewire events
        window.addEventListener('theme-changed', (event) => {
            this.preferences.theme = event.detail.theme;
            this.applyTheme();
        });

        window.addEventListener('sidebar-toggled', (event) => {
            this.preferences.sidebarCollapsed = event.detail.collapsed;
            this.applyLayout();
        });

        window.addEventListener('compact-mode-toggled', (event) => {
            this.preferences.compactMode = event.detail.enabled;
            this.applyLayout();
        });

        // Task-specific event listeners
        window.addEventListener('task-view-mode-changed', (event) => {
            this.preferences.taskViewMode = event.detail.mode;
            this.applyTaskPreferences();
        });

        window.addEventListener('task-overview-toggled', (event) => {
            this.preferences.taskShowOverview = event.detail.visible;
            this.applyTaskPreferences();
        });

        window.addEventListener('task-columns-toggled', (event) => {
            this.preferences.taskCollapsedColumns = event.detail.collapsed;
            this.applyTaskPreferences();
        });

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.preferences.theme === 'auto') {
                this.applyTheme();
            }
        });
    }

    // Utility methods for other components
    getTheme() {
        return this.preferences.theme;
    }

    isCompactMode() {
        return this.preferences.compactMode;
    }

    isSidebarCollapsed() {
        return this.preferences.sidebarCollapsed;
    }

    toggleSidebar() {
        this.preferences.sidebarCollapsed = !this.preferences.sidebarCollapsed;
        this.applyLayout();
        
        // Save the preference to the server
        if (window.Livewire) {
            window.Livewire.dispatch('sidebar-toggled', { collapsed: this.preferences.sidebarCollapsed });
        }
    }
}

// Initialize preferences when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.userPreferencesManager = new UserPreferences();
});

// Export for use in other modules
export default UserPreferences;
