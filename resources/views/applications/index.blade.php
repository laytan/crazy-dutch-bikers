@extends('layouts.app')

@section('content')
<div class="container">
    @component('components.title', ['icon' => 'fas fa-table'])
    Aanmeldingen
    @endcomponent
    <table class="table table-striped table-dark table-responsive-md">
        <caption>Alle aanmeldingen</caption>
        <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Telefoon</th>
                <th scope="col">Aangemeld op</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
            <tr scope="row">
                <td>{{ $application->name }}</td>
                <td>{{ $application->phone }}</td>
                <td>{{ formatTimeForDisplay($application->created_at) }}</td>
                <td>
                    <a href="{{ route('applications.show', ['application' => $application->id]) }}" class="btn btn-primary btn-sm mr-2">
                        Bekijken
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#remove-application-{{ $application->id }}-modal">
                      <i class="fas fa-trash"></i> Verwijderen
                    </button>
                    @component('components.modal', ['id' => 'remove-application-' . $application->id . '-modal', 'title' => 'Aanmelding Verwijderen'])
                    Weet u zeker dat de aanmelding van {{ $application->name }} verwijderd moet worden?
                    @slot('footer')
                    {{ Aire::open()->route('applications.destroy', ['application' => $application>id])->class('m-0 p-0') }}
                    {{ Aire::submit('Verwijderen') }}
                    {{ Aire::close() }}
                    @endslot
                    @endcomponent
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $applications->links() }}
</div>
@endsection
