@component('mail::message')
Bonjour,

Le mandat {{$compromis->numero_mandat}} vient d'être modifié. <hr><br>

<span style="color:#540F99 ;">
{{-- @if ($compromis->est_partage_agent == true &&  $compromis->je_porte_affaire == true) --}}
@if($compromis->date_vente != null)
@if ($compromis->date_vente->format('Y-m-d') != $requestcompromis->date_vente)
    Ancienne date de vente : {{ $compromis->date_vente->format('d-m-Y')}}
    Nouvelle date de vente : {{date('d-m-Y',strtotime($requestcompromis->date_vente))}} 
@endif  
@endif 

@if($destinataire == "mandataire")
@if ($compromis->pourcentage_agent != $requestcompromis->pourcentage_agent)
    Votre ancien pourcentage :  {{100 - $compromis->pourcentage_agent}} %
    Votre nouveau pourcentage : {{100 - $requestcompromis->pourcentage_agent}} %
@endif  
@endif 

{{-- @elseif($compromis->est_partage_agent == true &&  $compromis->je_porte_affaire == false) --}}
   

</span> <br>

<br><hr>
Bien cordialement,<br>
{{ config('app.name') }}
@endcomponent
