@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}}

Félicitation vous pouvez maintenant vous connecter sur l'outil de facturation : <a href="{{config('app.url')}}">Cliquez ici</a> pour vous connecter<br>
Login {{$mandataire->email}} <br>
Mot de passe : {{$password}}


@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
