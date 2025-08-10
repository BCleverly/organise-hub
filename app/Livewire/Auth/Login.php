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

    public function login()
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
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
