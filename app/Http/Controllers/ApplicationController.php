<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\ApplicationCreated;
use App\Http\Requests\CreateApplicationRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Storage;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage'])->except(['create', 'store']);
    }

    public function index(): View
    {
        $applications = Application::orderBy('created_at', 'DESC')->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function show(Application $application): View
    {
        return view('applications.show', compact('application'));
    }

    public function create(): View
    {
        return view('applications.create');
    }

    public function store(CreateApplicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Assign all mass assignment fields
        $application = new Application($validated);

        // Set non mass assignment fields, uses a setter in App\Application
        $application->person_picture = $request->file('person_picture')->store('applications', ['disk' => 'public']);
        $application->bike_picture = $request->file('bike_picture')->store('applications', ['disk' => 'public']);

        $application->save();

        // Dispatch application created event
        event(new ApplicationCreated($application));

        return redirect()
            ->route('applications.create')
            ->with('success', 'Uw aanvraag is verstuurd, wij nemen zo snel mogelijk contact op.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        // Delete images
        $s = Storage::disk('public');
        $s->delete($application->person_picture);
        $s->delete($application->bike_picture);

        // Delete row
        $application->delete();

        // Redirect to applications overview with success message
        return redirect()->route('applications.index')->with('success', 'Aanmelding verwijderd');
    }
}
