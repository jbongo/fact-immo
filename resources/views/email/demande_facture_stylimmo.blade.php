@component('mail::message')
# Nouvelle demande de facture,

Une demande de facture viens d'être effectuée par {{$mandataire->nom}}, {{$mandataire->prenom}}.

@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
