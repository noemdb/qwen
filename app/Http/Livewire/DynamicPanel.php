<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DynamicPanel extends Component
{
    public $currentView = 'dashboard'; // Vista predeterminada

    public function render()
    {
        return view('livewire.dynamic-panel');
    }

    public function changeView($view)
    {
        $this->currentView = $view;
    }
}