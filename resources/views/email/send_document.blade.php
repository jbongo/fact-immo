@component('mail::message')
# Bonjour {{$user->prenom}} {{$user->nom}}

Vous trouverez sur lien ci-dessous le document : {{$document->nom}}. <br>

@component('mail::button', ['url' => $url])
Voir le document
@endcomponent


Bonne réception. <br>

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent