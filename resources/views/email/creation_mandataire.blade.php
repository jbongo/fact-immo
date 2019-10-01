@component('mail::message')
# Bonjour {{$mandataire->nom}} {{$mandataire->nom}}

Félicitation vous pourrez maintenant vous connecter sur l'outil de facturation. <br>
Login {{$mandataire->email}} <br>
Mot de passe : {{$password}}


@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
{{ config('app.name') }}
@endcomponent
