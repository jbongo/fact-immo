@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


 Vous avez atteint la durée maximale du pack starter. <br>

@component('mail::panel')
<li>Vous passez de Starter à Expert. </li><br>
<li>  Votre commission passe de <strong>{{$ancienne_comm}} % à {{$nouvelle_comm}} % </strong>.</li> <br>

@endcomponent

<br><hr>



Durée du pack starter: **{{$duree_starter}} mois** <br>
Date de début d'activité : **{{$date_deb_activite->format('d/m/Y')}}**<br>



@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
