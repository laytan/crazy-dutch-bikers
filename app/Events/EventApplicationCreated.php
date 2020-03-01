<?php

namespace App\Events;

use App\EventApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventApplicationCreated
{
    use Dispatchable, SerializesModels;

    public $eventApplication;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EventApplication $eventApplication)
    {
        $this->eventApplication = $eventApplication;
    }
}
