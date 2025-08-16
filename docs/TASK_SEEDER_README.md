# Task Seeder Documentation

## Overview

The task seeder creates realistic test data for the task management feature, including:
- 6 test users with different roles and specialties
- 28 tasks across various categories and priorities
- Proper tagging system implementation
- Mix of task statuses (todo, in_progress, awaiting, completed)
- **Realistic task data** with due dates, priorities, and descriptions
- **User-specific task themes** (work, cooking, admin, etc.)

## Quick Start

### Basic Usage
```bash
# Seed tasks only
php artisan seed:tasks

# Fresh database with tasks
php artisan seed:tasks --fresh

# Seed both recipes and tasks together
php artisan seed:recipes --fresh

# Run all seeders (DatabaseSeeder)
php artisan db:seed
```

### Test Users Created

| User | Email | Role | Task Focus |
|------|-------|------|------------|
| Test User | test@example.com | General | Work, personal, learning |
| Admin User | admin@example.com | Administrator | System admin, reporting |
| Chef Sarah | sarah@example.com | Dessert Chef | Cooking, meal prep, baking |
| Chef Michael | michael@example.com | Main Course Chef | Professional cooking, kitchen management |
| Chef Emma | emma@example.com | Appetizer Chef | Events, party planning, appetizers |
| Chef David | david@example.com | Mixed Chef | Family cooking, blogging, photography |

**All users have password: `password`**

## Task Categories

### Task Statuses
- **todo**: Tasks that need to be started
- **in_progress**: Tasks currently being worked on
- **awaiting**: Tasks waiting for external input or dependencies
- **completed**: Finished tasks with completion timestamps

### Task Priorities
- **low**: Non-urgent tasks
- **medium**: Standard priority tasks
- **high**: Urgent or important tasks

### Task Tags
Tasks are tagged with relevant categories:
- **work**: Professional tasks
- **cooking**: Food-related tasks
- **admin**: Administrative tasks
- **personal**: Personal development tasks
- **learning**: Educational tasks
- **events**: Event planning tasks
- **documentation**: Documentation tasks
- **meeting**: Meeting-related tasks

## Task Data Structure

### Sample Task Data
```php
[
    'title' => 'Review project documentation',
    'description' => 'Go through the latest project documentation and update any outdated sections.',
    'status' => 'todo',
    'priority' => 'high',
    'due_date' => now()->addDays(3),
    'tags' => ['work', 'documentation', 'review'],
]
```

### Task Fields
- **title**: Task name/description
- **description**: Detailed task description
- **status**: Current task status
- **priority**: Task priority level
- **due_date**: Optional due date
- **completed_at**: Completion timestamp (for completed tasks)
- **user_id**: Associated user
- **tags**: Categorized tags for filtering

## Testing

### Test Coverage
The test suite covers:
- ✅ User and task creation
- ✅ Status and priority distribution
- ✅ User-task relationships
- ✅ Tag attachment and validation
- ✅ Task completion functionality
- ✅ Model scopes (status, priority, user)
- ✅ Task factory functionality
- ✅ Multiple seeder runs (idempotency)
- ✅ Due date handling
- ✅ Task-user relationships
- ✅ Task-tag relationships

### Manual Testing
```bash
# Run task seeder tests
php artisan test tests/Feature/TaskSeederTest.php

# Run all seeder tests
php artisan test --filter="SeederTest"
```

### Database Verification
```bash
# Check task statistics
php artisan tinker --execute="echo 'Tasks: ' . App\Models\Task::count(); echo 'Users with tasks: ' . App\Models\User::has('tasks')->count();"

# View user task distribution
php artisan tinker --execute="foreach(App\Models\User::with('tasks')->get() as \$user) { echo \$user->name . ': ' . \$user->tasks->count() . ' tasks' . PHP_EOL; }"
```

## Database Statistics

After running the seeder, you'll have:
- **6 users** with verified email addresses
- **28 tasks** with complete data
- **4 task statuses** distributed across tasks
- **3 priority levels** (low, medium, high)
- **Multiple task categories** via tagging system
- **Realistic due dates** and completion timestamps
- **User-specific task themes** for realistic testing

## Task Distribution

### Status Distribution
- **todo**: 14 tasks (50%)
- **in_progress**: 7 tasks (25%)
- **awaiting**: 3 tasks (11%)
- **completed**: 4 tasks (14%)

### Priority Distribution
- **high**: 12 tasks (43%)
- **medium**: 12 tasks (43%)
- **low**: 4 tasks (14%)

### User Task Distribution
- **Test User**: 5 tasks (work, personal, learning)
- **Admin User**: 5 tasks (admin, security, reporting)
- **Chef Sarah**: 5 tasks (cooking, meal prep, baking)
- **Chef Michael**: 5 tasks (professional cooking, kitchen)
- **Chef Emma**: 4 tasks (events, appetizers, party)
- **Chef David**: 4 tasks (family cooking, blogging)

## Integration with Other Features

The task seeder is designed to work with:
- **User authentication** (verified users)
- **Tag system** (Spatie Tags)
- **Task permissions** (user ownership)
- **Search and filtering** (tags, status, priority)
- **Due date management** (date calculations)
- **Task completion tracking** (status updates)
- **Progress reporting** (status distribution)
- **User dashboards** (task overviews)
- **Notification systems** (due date reminders)

This provides a solid foundation for testing all task-related features in your application.

## Troubleshooting

### Common Issues

1. **No Users Found**
   - Ensure DatabaseSeeder has been run first
   - Check that User model exists and is properly configured

2. **Task Creation Fails**
   - Verify Task model fillable fields
   - Check database migrations have been run
   - Ensure tag tables exist (Spatie Tags)

3. **Tag Attachment Issues**
   - Verify Spatie Tags package is installed
   - Check tag tables migration
   - Ensure Task model uses HasTags trait

4. **Duplicate Tasks**
   - TaskSeeder uses truncate to prevent duplicates
   - Check for unique constraints in database

5. **User-Task Relationship Issues**
   - Ensure Task model has proper user relationship
   - Check foreign key constraints
   - Verify User model has tasks relationship

### Reset Database
If you need to start completely fresh:
```bash
# Fresh database with all seeders
php artisan migrate:fresh --seed

# Or use the recipe seeder command (includes tasks)
php artisan seed:recipes --fresh
```

## Development Workflow

### Adding New Tasks
1. Edit `database/seeders/TaskSeeder.php`
2. Add task data to appropriate user array
3. Include relevant tags
4. Run `php artisan seed:tasks` to test

### Modifying Task Structure
1. Update Task model if needed
2. Modify TaskSeeder data structure
3. Update tests in `tests/Feature/TaskSeederTest.php`
4. Run tests to verify changes

### Custom Task Themes
To add new task themes:
1. Add task data to TaskSeeder
2. Include appropriate tags
3. Update documentation
4. Add tests for new functionality

This comprehensive task seeding system provides realistic, well-distributed test data for all task management features in your application.
