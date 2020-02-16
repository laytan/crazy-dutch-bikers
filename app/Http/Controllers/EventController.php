<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\CreateEventRequest;

class EventController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth')->except('index');
        $this->middleware('can:manage')->except('index');
    }

    private function dateTimeFieldsToTimestamp($date, $time)
    {
        $dateParts = explode('-', $date);
        $timeParts = explode(':', $time);
        return Carbon::create($dateParts[0], $dateParts[1], $dateParts[2], $timeParts[0], $timeParts[1], null, 'CET');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $futureEvents = Event::getFutureOrdered();
        $pastEvents = Event::getPastOrdered();
        return view('events.index', compact('futureEvents', 'pastEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated();

        $event = new Event($validatedData);

        $fullDay = true;
        $time = '00:00';
        if ($validatedData['time'] !== null) {
            $time = $validatedData['time'];
            $fullDay = false;
        }

        $endTime = '00:00';
        if ($validatedData['end_time'] !== null) {
            $endTime = $validatedData['end_time'];
        }

        if ($validatedData['end_date'] !== null) {
            $event->timestamp_end = $this->dateTimeFieldsToTimestamp($validatedData['end_date'], $endTime);
        }

        $event->timestamp   = $this->dateTimeFieldsToTimestamp($validatedData['date'], $time);
        $event->full_day    = $fullDay;

        $event->uploadPicture($request->file('picture'));

        $event->save();

        return redirect()->route('events.index')->with('success', 'Evenement toegevoegd');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
