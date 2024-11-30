<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Event;

class EventDisplay extends Component
{
    public $events;

    public function __construct()
    {
        // Fetch all events to display
        $this->events = Event::all();
    }

    public function render()
    {
        return view('components.event');
    }
}
