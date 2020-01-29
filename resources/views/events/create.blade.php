@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>Evenement aanmaken</h2>
  <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="title">Titel *</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="Titel" required>
    </div>
    <div class="form-group">
      <label for="description">Beschrijving *</label>
      <textarea type="text" name="description" id="description" class="form-control" placeholder="Beschrijving" required></textarea>
    </div>
    <div class="form-group">
      <label for="location">Locatie *</label>
      <textarea type="text" name="location" id="location" class="form-control" placeholder="Locatie" required></textarea>
    </div>
    <div class="form-group">
      <label for="picture">Foto *</label>
      <input type="file" name="picture" id="picture" class="form-control-file" required>
    </div>
    <div class="row">
      <div class="col-6 form-group">
        <label for="date">Datum *</label>
        <input type="date" name="date" id="date" class="form-control" required>
      </div>
      <div class="col-6 form-group">
        <label for="time">Tijd</label>
        <input type="text" name="time" id="time" class="form-control" placeholder="hh:mm">
        <small>Vul in als 12:00 of 23:00</small> <br>
        <small>Laat leeg om zonder tijd aan te geven</small>
      </div>
    </div>
    <div class="row">
      <div class="col-6 form-group">
        <label for="end_date">Eind datum</label>
        <input type="date" name="end_date" id="end_date" class="form-control">
        <small>Laat leeg om zonder eind tijd aan te geven</small>
      </div>
      <div class="col-6 form-group">
        <label for="end_time">Eind tijd</label>
        <input type="text" name="end_time" id="end_time" class="form-control" placeholder="hh:mm">
        <small>Vul in als 12:00 of 23:00</small> <br>
        <small>Laat leeg om zonder eind tijd aan te geven</small>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-6">
        <label for="location_link">Locatie link</label>
        <input type="url" name="location_link" id="location_link" class="form-control" placeholder="Locatie link">
        <small>Laat leeg om nergens naartoe te linken</small>
      </div>
      <div class="form-group col-6">
        <label for="facebook_link">Facebook link</label>
        <input type="url" name="facebook_link" id="facebook_link" class="form-control" placeholder="Facebook link">
        <small>Laat leeg om nergens naartoe te linken</small>
      </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Aanmaken">
  </form>
</div>
@endsection
