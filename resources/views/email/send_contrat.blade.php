@component('mail::message')
# Bonjour {{$prospect->prenom}} {{$prospect->nom}}

Vous trouverez en pièce jointe votre contrat STYL'IMMO. <br>

Bonne réception. <br>

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent