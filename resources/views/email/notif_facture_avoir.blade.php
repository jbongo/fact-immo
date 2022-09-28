@component('mail::message')
Bonjour {{$mandataire->nom}} {{$mandataire->prenom}},

Un avoir vient d'être généré sur votre facture {{$facture->type}} <span style="color:#d83939 ;"> {{$facture->numero}} </span>. <hr><br>

<span style="color:#540F99 ;">
Vous trouverez en pièce jointe votre facture initiale et votre facture d'avoir.
</span> <br>

<br><hr>
Bien cordialement,<br>
{{ config('app.name') }}
@endcomponent
