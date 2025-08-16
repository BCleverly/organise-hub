<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginUser;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public bool $remember = false;

    public function login(): mixed
    {
        $this->validate();

        try {
            $user = LoginUser::run([
                'email' => $this->email,
                'password' => $this->password,
                'remember' => $this->remember,
            ]);

            session()->regenerate();

            return redirect()->intended(route('dashboard'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
        }

        return null;
    }

    public function quickLogin(string $email): mixed
    {
        // Only allow in development environment
        if (! app()->environment('local', 'development', 'testing')) {
            abort(403, 'Quick login is only available in development.');
        }

        try {
            $user = LoginUser::run([
                'email' => $email,
                'password' => 'password', // Default password for test accounts
                'remember' => false,
            ]);

            session()->regenerate();

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            $this->addError('email', 'Quick login failed. Please use the regular login form.');
        }

        return null;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.login');
    }
}
