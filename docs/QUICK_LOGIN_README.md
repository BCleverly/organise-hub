# Quick Login Feature

## Overview

The Quick Login feature provides a convenient way to log into test accounts during development. This feature is **only available in development environments** and will never be accessible in production.

## Features

- **Development Only**: Only visible in `local`, `development`, and `testing` environments
- **Test Accounts**: Provides quick access to predefined test accounts
- **Secure**: Automatically blocked in production environments
- **User-Friendly**: Clear visual indicators that this is for development only

## Available Test Accounts

The following test accounts are available for quick login:

1. **Test User**
   - Email: `test@example.com`
   - Password: `password`
   - Description: Standard test user account

2. **Admin User**
   - Email: `admin@example.com`
   - Password: `password`
   - Description: Admin test user account

## How to Use

1. Navigate to the login page (`/login`)
2. Look for the yellow "Development Quick Login" section
3. Click either:
   - "👤 Login as Test User" for the standard test account
   - "👑 Login as Admin" for the admin test account
4. You'll be automatically logged in and redirected to the dashboard

## Security

- **Environment Check**: The feature is only available in development environments
- **Production Block**: Attempting to access quick login in production will result in a 403 error
- **No Production Risk**: The UI elements are completely hidden in production

## Technical Implementation

### Backend (PHP)

```php
// In app/Livewire/Auth/Login.php
public function quickLogin(string $email): mixed
{
    // Only allow in development environment
    if (!app()->environment('local', 'development', 'testing')) {
        abort(403, 'Quick login is only available in development.');
    }
    
    // Login logic...
}
```

### Frontend (Blade)

```blade
@if(app()->environment('local', 'development', 'testing'))
    <!-- Quick Login UI -->
@endif
```

## Testing

The feature includes comprehensive tests:

- **Unit Tests**: Test the quick login method functionality
- **Integration Tests**: Test the UI rendering and button presence
- **Security Tests**: Verify the feature is blocked in production
- **Error Handling**: Test invalid credentials and non-existent users

Run tests with:
```bash
php artisan test --filter="QuickLogin"
```

## Database Seeding

The test accounts are created by the database seeder:

```php
// In database/seeders/DatabaseSeeder.php
User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);

User::factory()->create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
```

## Environment Configuration

The feature respects the following environment variables:

- `APP_ENV=local` - Feature enabled
- `APP_ENV=development` - Feature enabled  
- `APP_ENV=testing` - Feature enabled
- `APP_ENV=production` - Feature disabled
- `APP_ENV=staging` - Feature disabled

## Troubleshooting

### Quick Login Not Visible

1. Check your environment: `echo $APP_ENV`
2. Ensure you're in `local`, `development`, or `testing` environment
3. Clear view cache: `php artisan view:clear`

### Quick Login Fails

1. Ensure test accounts exist in database
2. Run database seeder: `php artisan db:seed`
3. Check that passwords match the expected value (`password`)

### Tests Failing

1. Ensure test environment is properly configured
2. Run tests with: `php artisan test --filter="QuickLogin"`
3. Check that database is properly seeded for tests
