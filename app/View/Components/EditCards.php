<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditCards extends Component
{
    public $image;
    public $title;
    public $date;
    public $startTime;
    public $endTime;
    public $location;
    public $id;
    public $address;
    public $description;
    public $route; // New property for the form action route

    /**
     * Create a new component instance.
     *
     * @param string|null $image
     * @param string $title
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @param string $location
     * @param int $id
     * @param string|null $address
     * @param string $description
     * @param string $route // Add $route parameter
     */
    public function __construct($image, $title, $date, $startTime, $endTime, $location, $id, $address, $description, $route)
    {
        $this->image = $image;
        $this->title = $title;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->location = $location;
        $this->id = $id;
        $this->address = $address;
        $this->description = $description;
        $this->route = $route;
    }

    /**
     * Get the view that represents the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.edit-cards');
    }
}
