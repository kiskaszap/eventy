<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EventCard extends Component
{
    public $image;
    public $title;
    public $date;
    public $startTime;
    public $endTime;
    public $location;
    public $id;
    public $route; // New property for the route

    public function __construct($image, $title, $date, $startTime, $endTime, $location, $id, $route)
    {
        $this->image = $image;
        $this->title = $title;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->location = $location;
        $this->id = $id;
        $this->route = $route; // Assign the route dynamically
    }

    public function render()
    {
        return view('components.event-card');
    }
}
