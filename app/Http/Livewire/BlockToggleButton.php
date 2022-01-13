<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class BlockToggleButton extends Component
{
    public Model $model;
    public string $field;
    public bool $isActive;

    public int $userID;

    public function mount() {
        $theAttribute = $this->model->find($this->userID)->getAttribute($this->field);
        $this->isActive = (bool) $theAttribute;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.block-toggle-button');
    }

    public function updating($field, $value) {
        $this->model->find($this->userID)->setAttribute($this->field, $value)->save();
        $this->emit('saved');
    }
}
