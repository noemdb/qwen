<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardLayout extends Component
{
    public $showLeftSidebar = true;
    public $showRightSidebar = true;

    public function toggleSidebar($sidebar)
    {
        if ($sidebar === 'left') {
            $this->showLeftSidebar = !$this->showLeftSidebar;
        } elseif ($sidebar === 'right') {
            $this->showRightSidebar = !$this->showRightSidebar;
        }
    }

    public function render()
    {
        return view('livewire.dashboard-layout');
    }
}