<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function __constructor() {
        $this->middleware('auth')->except('index');
        $this->middleware('can:manage')->except('index');
    }

    private function dateTimeFieldsToTimestamp($date, $time) {
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255|min:1',
            'description'   => 'required|string|min:1|max:1000',
            'location'      => 'required|string|min:1|max:255',
            'location_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'date'          => 'required|date',
            'end_date'      => 'nullable|date',
            'time'          => ['nullable', 'string', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'end_time'      => ['nullable', 'string', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'picture'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = new Event;
        
        $fullDay = true;
        $time = '00:00';
        if($validatedData['time'] !== null) {
            $time = $validatedData['time'];
            $fullDay = false;
        }

        $endTime = '00:00';
        if($validatedData['end_time'] !== null) {
            $endTime = $validatedData['end_time'];
        }

        if($validatedData['end_date'] !== null) {
            $event->timestamp_end = $this->dateTimeFieldsToTimestamp($validatedData['end_date'], $endTime);
        }

        $event->timestamp   = $this->dateTimeFieldsToTimestamp($validatedData['date'], $time);
        $event->picture     = $request->file('picture')->store('event-pictures', ['disk' => 'public']);
        $event->title       = $validatedData['title'];
        $event->description = $validatedData['description'];
        $event->location    = $validatedData['location'];
        $event->full_day    = $fullDay;

        if($validatedData['location_link'] !== null) {
            $event->location_link = $validatedData['location_link'];
        }
        if($validatedData['facebook_link'] !== null) {
            $event->facebook_link = $validatedData['facebook_link'];
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Evenement toegevoegd');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
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
