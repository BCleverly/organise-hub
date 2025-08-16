<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\RegisterUser;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Register extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255|unique:users')]
    public string $email = '';

    #[Rule('required|min:8|confirmed')]
    public string $password = '';

    #[Rule('required|same:password')]
    public string $password_confirmation = '';

    public function register(): mixed
    {
        $this->validate();

        try {
            $user = RegisterUser::run([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ]);

            auth()->login($user);

            session()->regenerate();

            return redirect()->route('dashboard');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
        }

        return null;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.register');
    }
}
