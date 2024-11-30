<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SingleEventDisplay extends Component
{
    public $event; // Adat tárolásához

    /**
     * Create a new component instance.
     *
     * @param  mixed  $event
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event; // Prop értékének tárolása
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.single-event-display');
    }
}
