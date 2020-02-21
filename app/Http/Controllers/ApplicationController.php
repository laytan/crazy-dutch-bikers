<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\ApplicationCreated;
use App\Http\Requests\CreateApplicationRequest;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage'])->only(['index', 'show']);
    }

    public function index()
    {
        $applications = Application::orderBy('created_at', 'DESC')->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(CreateApplicationRequest $request)
    {
        $validated = $request->validated();

        // Assign all mass assignment fields
        $application = new Application($validated);

        // Set non mass assignment fields, uses a setter in App\Application
        $application->person_picture = $request->file('person_picture');
        $application->bike_picture = $request->file('bike_picture');

        $application->save();

        // Dispatch application created event
        event(new ApplicationCreated($application));

        return redirect()
            ->route('applications.create')
            ->with('success', 'Uw aanvraag is verstuurd, wij nemen zo snel mogelijk contact op.');
    }
}
