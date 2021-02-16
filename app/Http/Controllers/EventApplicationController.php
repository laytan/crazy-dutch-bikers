<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventApplicationRequest;
use App\Event;
use App\EventApplication;
use App\Events\EventApplicationCreated;
use Illuminate\Http\RedirectResponse;

class EventApplicationController extends Controller
{
    /**
     * Create new event application
     */
    public function store(CreateEventApplicationRequest $request, Event $event): RedirectResponse
    {
        $eventApplication = new EventApplication($request->validated());
        $eventApplication->event_id = $event->id;
        $eventApplication->save();

        event(new EventApplicationCreated($eventApplication));

        return redirect()->route('events.index')->with('success', 'Je bent aangemeld!');
    }
}
