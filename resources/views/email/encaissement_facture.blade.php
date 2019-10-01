@component('mail::message')
# Bonjour

Votre facture stylimmo N° {{$facture->numero}} a bien été encaissée.


Bien cordialement,<br>
{{ config('app.name') }}
@endcomponent
