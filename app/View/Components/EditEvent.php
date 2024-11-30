<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditEvent extends Component
{
    public $event;

    /**
     * Create a new component instance.
     *
     * @param \App\Models\Event $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
{
    return view('components.edit-event', ['event' => $this->event]);
}

}
