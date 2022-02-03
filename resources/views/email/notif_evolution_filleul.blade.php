@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


Après 3 ans de parrainnage, vos droits de commission sur les affaires de votre filleul viennent d'expirer. <br>

@component('mail::panel')
Filleul concerné: {{$mandataire_filleul->prenom}} {{$mandataire_filleul->nom}},

@endcomponent

<br><hr>


@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
