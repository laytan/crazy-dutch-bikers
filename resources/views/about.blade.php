@extends('layouts.app')

@section('title', ' - Over de Crazy Dutch Bikers')

@section('content')
<div class="h-vh position-relative">
  <div style="background: linear-gradient(45deg, rgba(33,37,41,1) 0%, rgba(33,37,41,1) 10%, rgba(33,37,41,0) 100%);" class="w-100 h-100 position-absolute"></div>
  <img class="w-100 h-100 object-fit-cover pb-1 bg-cdbg" src="{{ url('images/over-ons-1.jpeg') }}" alt="De Crazy Dutch Bikers leden">
  <div style="bottom: 10%; left: 5%;" class="position-absolute d-flex">
    <img style="height: 1px; padding-top: .5rem;" class="mr-3 d-none d-md-block" data-match="#overlay-text" src="{{ url('/images/cdb-logo.png') }}" alt="Crazy Dutch Bikers logo">
    <div id="overlay-text">
      <h2>
        <span class="h1 text-primary">Cra<span class="h5 text-primary">Z</span>y</span> Dutch Bikers
      </h2>
      <p class="mb-0">Een leuke groep crazy mensen die van een feestje houden.</p>
    </div>
  </div>
</div>
<div class="container mt-5">
  <div class="row mb-6">
    <div class="col-12 col-md-7 pr-md-5">
      <h2 class="pt-0">Welkom</h2>
      <p class="mb-md-0">
        Crazy Dutch Bikers is een Motor Touring Club dat graag zijn passie voor motoren en motorrijden deelt met andere
        motorrijders. De club is ontstaan uit een groep vrienden die de passie voor motorrijden delen. Wij staan voor
        broederschap, vertrouwen en gezelligheid. Zowel mannelijke als vrouwelijke motorrijders zijn welkom. Zoals in onze
        naam staat zijn wij een club die gericht is op toeren, hierdoor zijn bijna alle motoren welkom, met uitzondering van
        racers.
        Dit omdat onze toerritten gebaseerd zijn op een andere rijstel.
      </p>
    </div>
    <div class="col-12 col-md-5">
      <img class="w-100 h-100 object-fit-cover rounded-lg bg-cdbg p-1" src="{{ url('images/over-ons-2.jpeg') }}" alt="De Crazy Dutch Bikers leden">
    </div>
  </div>
  <div class="row mb-6">
    <div class="col-12 col-md-5 order-2 order-md-1">
      <img class="w-100 h-100 object-fit-cover rounded-lg bg-cdbg p-1" src="{{ url('images/over-ons-2.jpeg') }}" alt="De Crazy Dutch Bikers leden">
    </div>
    <div class="col-12 col-md-7 pl-md-5 order-1 order-md-2">
      <h2 class="pt-0 text-right">Standplaats</h2>
      <p class="mb-md-0">
        Naast het motorrijden en het bezoeken van evenementen komen wij regelmatig bij elkaar om de broederschap te
        vergroten en er een leuke avond van te maken. Onze standplaats is daarbij cafe fly in aan de Vlinderveen 477 in
        Spijkenisse. Elke eerste zaterdag van de maand komen wij hier samen om te genieten onder het genot van een drankje
        met livemuziek.
      </p>
    </div>
  </div>
  <div class="row mb-6">
    <div class="col-12 col-md-7 pr-md-5">
      <h2 class="pt-0">Evenementen</h2>
      <p class="m-0">
        Verder zullen we hier op de site motor evenementen posten en onze ritten, waarbij je ook als je geen lid van onze
        club ben, bij aan kan sluiten. Want laten we eerlijk wezen we vinden het allemaal super toch om met een grote groep
        te rijden, en plezier te maken.
      </p>
      <a href="{{ route('events.index') }}" class="btn btn-primary mt-3 mb-4 mb-md-0">
        Bekijk evenementen
      </a>
    </div>
    <div class="col-12 col-md-5">
      <img class="w-100 h-100 object-fit-cover rounded-lg bg-cdbg p-1" src="{{ url('images/over-ons-2.jpeg') }}" alt="De Crazy Dutch Bikers leden">
    </div>
  </div>
  <div class="row mb-6">
    <div class="col-12 col-md-5 order-2 order-md-1">
      <img class="w-100 h-100 object-fit-cover rounded-lg bg-cdbg p-1" src="{{ url('images/over-ons-2.jpeg') }}" alt="De Crazy Dutch Bikers leden">
    </div>
    <div class="col-12 col-md-7 pl-md-5 order-1 order-md-2">
      <h2 class="pt-0 text-right">Spontane Ritten</h2>
      <p class="m-md-0">
        Ook is het mogelijk om via Whatsapp in onze spontane ritten app te komen
        Geef hiervoor je info door en wij zorgen dat je in de app komt. Als je dan spontaan een keer zin heb om te gaan
        rijden kan je dit kenbaar maken en misschien zijn er meer mensen die dan met je mee rijden.
      </p>
    </div>
  </div>
</div>
@endsection
