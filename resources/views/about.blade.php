@extends('layouts.app')

@section('content')
<div>
  <img src="{{ url('images/over-ons-1.jpeg') }}" alt="De Crazy Dutch Bikers leden">
  <img src="{{ url('images/over-ons-2.jpeg') }}" alt="De Crazy Dutch Bikers leden">
</div>
<div class="container">
  <div class="text-center">
    @component('components.title')
      Welkom bij MTC Crazy Dutch Bikers
    @endcomponent
  </div>
  <p>
    Crazy Dutch Bikers is een Motor Touring Club dat graag zijn passie voor motoren en motorrijden deelt met andere
    motorrijders. De club is ontstaan uit een groep vrienden die de passie voor motorrijden delen. Wij staan voor
    broederschap, vertrouwen en gezelligheid. Zowel mannelijke als vrouwelijke motorrijders zijn welkom. Zoals in onze
    naam staat zijn wij een club die gericht is op toeren, hierdoor zijn bijna alle motoren welkom, met uitzondering van
    racers.
    Dit omdat onze toerritten gebaseerd zijn op een andere rijstel.
  </p>
  <p>
    Naast het motorrijden en het bezoeken van evenementen komen wij regelmatig bij elkaar om de broederschap te
    vergroten en er een leuke avond van te maken. Onze standplaats is daarbij cafe fly in aan de Vlinderveen 477 in
    Spijkenisse. Elke eerste zaterdag van de maand komen wij hier samen om te genieten onder het genot van een drankje
    met livemuziek.
  </p>
  <p>
    Verder zullen we hier op de site motor evenementen posten en onze ritten, waarbij je ook als je geen lid van onze
    club ben, bij aan kan sluiten. Want laten we eerlijk wezen we vinden het allemaal super toch om met een grote groep
    te rijden, en plezier te maken.
  </p>
  <p>
    Ook is het mogelijk om via Whatsapp in onze spontane ritten app te komen
    Geef hiervoor je info door en wij zorgen dat je in de app komt. Als je dan spontaan een keer zin heb om te gaan
    rijden kan je dit kenbaar maken en misschien zijn er meer mensen die dan met je mee rijden
  </p>
</div>
@endsection
