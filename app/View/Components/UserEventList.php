<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserEventList extends Component
{
    public $registrations;

    /**
     * Create a new component instance.
     *
     * @param \Illuminate\Support\Collection $registrations
     */
    public function __construct($registrations)
    {
        $this->registrations = $registrations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-event-list');
    }
}
