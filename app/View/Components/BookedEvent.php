<?php
namespace App\View\Components;

use Illuminate\View\Component;

class BookedEvent extends Component
{
    public $event;
    public $image;
    public $title;
    public $date;
    public $startTime;
    public $endTime;
    public $location;
    public $description;
    public $address;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($event, $image, $title, $date, $startTime, $endTime, $location, $description, $address)
    {
        $this->event = $event;
        $this->image = $image;
        $this->title = $title;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->location = $location;
        $this->description = $description;
        $this->address = $address;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.booked-event');
    }
}
