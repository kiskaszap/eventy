<?php
namespace App\View\Components;

use Illuminate\View\Component;

class SingleEventDisplay extends Component
{
    public $event;
    public $comments; // Likely here

    public $route; // New property for the form action route

    public function __construct($event, $comments, $route)
    {
        $this->event = $event;
        $this->comments = $comments;
        $this->route = $route;

    }

    public function render()
    {
        return view('components.single-event-display');
    }
}
