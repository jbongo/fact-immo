@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


@if($mandataire->contrat->nb_vente_passage_expert > 0)

Vous avez atteint le nombre de vente requis pour passer à Expert. <br>
@else 
Vous avez atteint la durée maximale du pack starter. <br>
@endif

@component('mail::panel')
<li>Vous passez de Starter à Expert. </li><br>
<li>  Votre commission passe de <strong>{{$ancienne_comm}} % à {{$nouvelle_comm}} % </strong>.</li> <br>

@endcomponent

<br><hr>


@if($mandataire->contrat->nb_vente_passage_expert > 0)
Nombre de vente pour devenir Expert: **{{$mandataire->contrat->nb_vente_passage_expert}} ** <br>
@else 
Durée du pack starter: **{{$duree_starter}} mois** <br>
@endif
Date de début d'activité : **{{$date_deb_activite->format('d/m/Y')}}**<br>



@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
