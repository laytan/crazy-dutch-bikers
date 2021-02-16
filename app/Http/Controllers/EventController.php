<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Storage;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage'])->except('index');
    }

    private function dateTimeFieldsToTimestamp($date, $time): Carbon
    {
        $dateParts = explode('-', $date);
        $timeParts = explode(':', $time);
        return Carbon::create($dateParts[0], $dateParts[1], $dateParts[2], $timeParts[0], $timeParts[1], null, 'CET');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $futureEvents = Event::getFutureOrdered();
        $pastEvents = Event::getPastOrdered();
        return view('events.index', compact('futureEvents', 'pastEvents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request): RedirectResponse
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

        $event->timestamp = $this->dateTimeFieldsToTimestamp($validatedData['date'], $time);
        $event->full_day = $fullDay;

        $event->uploadPicture($request->file('picture'));

        $event->save();

        return redirect()->route('events.index')->with('success', 'Evenement toegevoegd');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $validatedData = $request->validated();

        // Remove null fields from array
        $event->fill(
            array_filter(
                $validatedData,
                fn ($data) => $data !== null
            )
        );

        if ($validatedData['date'] !== null) {
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
            } else {
                $event->timestamp_end = null;
            }

            $event->timestamp = $this->dateTimeFieldsToTimestamp($validatedData['date'], $time);
            $event->full_day = $fullDay;
        }

        if ($request->file('picture') !== null) {
            $event->uploadPicture($request->file('picture'));
        }

        $event->save();
        return redirect()->route('events.index')->with('success', 'Evenement bewerkt');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        Storage::disk('public')->delete($event->picture);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evenement verwijderd');
    }
}
