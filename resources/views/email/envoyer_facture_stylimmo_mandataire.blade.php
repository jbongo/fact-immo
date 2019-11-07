@component('mail::message')
# Bonjour {{$mandataire->nom}} {{$mandataire->prenom}}

Vous trouverez en pièce jointe la facture STYL'IMMO <span style="color:red">F{{$facture->numero}}</span>
<br>
Mandat : {{$facture->compromis->numero_mandat}} <br>
Date de vente prévue le : {{$facture->compromis->date_vente->format('d/m/Y')}} <br>

Bonne réception. <br>
Bien cordialement, <br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">


@endcomponent
