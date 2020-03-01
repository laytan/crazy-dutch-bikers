<?php

namespace App\Listeners;

use App\Events\ApplicationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendApplicationEmailNotification implements ShouldQueue
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
     * @param  ApplicationCreated  $event
     * @return void
     */
    public function handle(ApplicationCreated $event)
    {
        $receivers = parseConfigReceivers(config('app.application_receivers'));
        foreach ($receivers as $receiver) {
            Mail::to($receiver['email'], $receiver['name'])
                ->send(new \App\Mail\ApplicationCreated($event->application));
        }
    }
}
