@component('mail::message')
# Bonjour {{$contrat->user->prenom}} {{$contrat->user->nom}}

Vous trouverez en pièce jointe votre contrat STYL'IMMO à nous rétourner après signature. <br>

Bonne réception. <br>

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent