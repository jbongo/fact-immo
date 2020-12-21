@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}}

Vous venez de changer de palier <br>

Ancien pourcentage : {{$ancien_pourcentant}} % <br>
Nouveau pourcentage : {{$nouveau_pourcentant}} % <br>

@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
