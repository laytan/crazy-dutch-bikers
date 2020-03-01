<?php

namespace App\Mail;

use App\EventApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventApplicationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $eventApplication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EventApplication $eventApplication)
    {
        $this->eventApplication = $eventApplication;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.eventApplications.created')
            ->subject("Nieuwe aanmelding voor evenement {$this->eventApplication->event->title} op Crazy Dutch Bikers");
    }
}
