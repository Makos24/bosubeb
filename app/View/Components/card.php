<?php

namespace App\View\Components;

use Illuminate\View\Component;

class card extends Component
{
    public $staff, $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($staff, $title)
    {
        $this->staff = $staff;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
