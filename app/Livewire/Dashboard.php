<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithUserPreferences;
use Livewire\Component;

class Dashboard extends Component
{
    use WithUserPreferences;

    public function render(): \Illuminate\View\View
    {
        $this->injectUserPreferences();

        return view('livewire.dashboard')
            ->layout('components.layouts.app');
    }
}
