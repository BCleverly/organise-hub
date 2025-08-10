<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\SendPasswordResetLink;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ForgotPassword extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    public bool $emailSent = false;

    public function sendResetLink()
    {
        $this->validate();

        try {
            SendPasswordResetLink::run([
                'email' => $this->email,
            ]);

            $this->emailSent = true;
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
        return view('livewire.auth.forgot-password');
    }
}
