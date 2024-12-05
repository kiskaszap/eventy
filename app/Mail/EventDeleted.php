<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $vendor)
    {
        $this->event = $event;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Event Deleted Notification')
                    ->view('emails.event-deleted');
    }
}
