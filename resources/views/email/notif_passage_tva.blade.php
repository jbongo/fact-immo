@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}}

Vous venez de passer à la tva <br>

@if($mandataire->numero_tva)
<span>Pensez à fournir votre numéro TVA au siège le plus tôt possible.</span>
@endif
<br>
Votre Chiffre d'affaire depuis le début de l'année {{$mandataire->email}} <br>
Le  : {{$password}}


@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
