<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ResetPasswordForm extends Component
{
    #[Rule('required')]
    public string $token = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|min:8|confirmed')]
    public string $password = '';

    #[Rule('required|same:password')]
    public string $password_confirmation = '';

    public bool $passwordReset = false;

    public function mount(string $token): void
    {
        $this->token = $token;
    }

    public function resetPassword(): void
    {
        $this->validate();

        try {
            \App\Actions\Auth\ResetPassword::run([
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ]);

            $this->passwordReset = true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.reset-password');
    }
}
