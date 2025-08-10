<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LogoutUser;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        LogoutUser::run();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
