<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardLayout extends Component
{
    public $title;
    public $customScript;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title=null,$customScript=null)
    {
        $this->title = $title;
        $this->customScript = $customScript;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-layout');
    }
}

