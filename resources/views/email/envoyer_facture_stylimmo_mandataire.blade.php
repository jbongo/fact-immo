@component('mail::message')
# Bonjour {{$mandataire->prenom}}

Vous trouverez en pièce jointe votre facture stylimmo.
Description du bien  : {{$facture->compromis->description_bien}} à {{$facture->compromis->ville_bien}}

Merci,<br>
{{ config('app.name') }}
@endcomponent
