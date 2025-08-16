<?php

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPasswordForm;
use App\Livewire\Dashboard;
use App\Livewire\Habits;
use App\Livewire\Habits\CreateHabit;
use App\Livewire\Recipes;
use App\Livewire\Tasks;
use App\Livewire\UserPreferences;
use Illuminate\Support\Facades\Route;

Route::passkeys();

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPasswordForm::class)->name('password.reset');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::personalDataExports('personal-data-exports');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/habits', Habits::class)->name('habits');
    Route::get('/habits/create', CreateHabit::class)->name('habits.create');
    Route::get('/tasks', Tasks::class)->name('tasks');
    Route::get('/tasks/create', \App\Livewire\Tasks\CreateTask::class)->name('tasks.create');
    Route::get('/tasks/{task}/edit', \App\Livewire\Tasks\EditTask::class)->name('tasks.edit');
    Route::get('/recipes', Recipes::class)->name('recipes');
    Route::get('/recipes/create', \App\Livewire\Recipes\CreateRecipe::class)->name('recipes.create');
    Route::get('/recipes/{recipe}/edit', \App\Livewire\Recipes\EditRecipe::class)->name('recipes.edit');
    Route::get('/recipes/{recipe}', \App\Livewire\Recipes\RecipeDetail::class)->name('recipes.show');
    Route::get('/preferences', UserPreferences::class)->name('preferences');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});
