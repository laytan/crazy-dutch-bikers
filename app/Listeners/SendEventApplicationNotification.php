<?php

namespace App\Listeners;

use App\Events\EventApplicationCreated;
use App\Mail\EventApplicationCreated as MailEventApplicationCreated;
use Mail;

class SendEventApplicationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventApplicationCreated $event)
    {
        $receivers = parseConfigReceivers(config('app.application_receivers'));
        foreach ($receivers as $receiver) {
            Mail::to($receiver['email'], $receiver['name'])
                ->send(new MailEventApplicationCreated($event->eventApplication));
        }
    }
}
