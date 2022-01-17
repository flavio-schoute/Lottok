<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PlaceBet extends Component
{
    public bool $clicked;

    public function render(): Factory|View|Application
    {
        return view('livewire.place-bet');
    }
}
