<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class LogoutUser
{
    use AsAction;

    public function handle(): void
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
