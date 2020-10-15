@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


Vous êtes arrivé à votre date d'anniversaire de début d'activité **({{$date_deb_activite->format('d/m/Y')}})**. <br>

@component('mail::panel')
Votre commission passe de {{$ancienne_comm}} % à {{$nouvelle_comm}} %. <br>

@endcomponent

<br><hr>
<strong> Sur la période du {{$date_deb}} au {{$date_fin}} : </strong> 
<br>
<br>


Chiffre d'affaire: **{{$chiffre_affaire}}** <br>
Nombre de vente : **{{$nb_vente}}**<br>
Nombre de filleul parrainé : **{{$nb_filleul}}**<br>


@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
