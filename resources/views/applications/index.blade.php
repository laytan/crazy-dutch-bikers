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
                    <a href="{{ route('applications.show', ['application' => $application->id]) }}" class="btn btn-primary btn-sm">
                        Bekijken
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $applications->links() }}
</div>
@endsection
