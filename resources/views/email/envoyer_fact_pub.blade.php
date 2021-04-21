@component('mail::message')
# Bonjour {{$mandataire->nom}} {{$mandataire->prenom}}

Vous trouverez en pièce jointe la facture PUB et OUTILS INFORMATIQUES du mois de {{$mois}} <span style="color:red">F{{$facture->numero}}</span>
<br>

Bonne réception. <br>
Bien cordialement, <br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">


@endcomponent
