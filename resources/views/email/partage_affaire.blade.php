@component('mail::message')
Bonjour,

{{$mandataire->nom}} {{$mandataire->prenom}} vient d'ajouter une affaire partagée avec vous. <hr><br>

<span style="color:#540F99 ;">
@if ($compromis->est_partage_agent == true &&  $compromis->je_porte_affaire == true)
    Vous ne portez pas l'affaire<br>
    Numéro de mandat : {{ $compromis->numero_mandat}} 
@elseif($compromis->est_partage_agent == true &&  $compromis->je_porte_affaire == false)
    Vous portez l'affaire <br>
    Numéro de mandat : {{$compromis->numero_mandat_porte_pas}}
@endif
</span> <br>
<span style="color:#540F99 ;"> Votre pourcentage :  {{100 - $compromis->pourcentage_agent}} %</span> 

<br><hr>
Bien cordialement,<br>
{{ config('app.name') }}
@endcomponent
