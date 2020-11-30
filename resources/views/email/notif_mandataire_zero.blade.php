@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


Vous êtes arrivés à votre date d'anniversaire de début d'activité le : **({{$date_deb_activite->format('d/m/Y')}})**. <br>

@component('mail::panel')
Suivant les termes de votre contrat, votre commission passe de {{$ancienne_comm}} % à {{$nouvelle_comm}} %. <br>
Votre chiffre d'affaires STYL'IMMO a été remis à **0**. <br>

@endcomponent

<br><hr>
<strong> Sur la période du {{$date_deb}} au {{$date_fin}} : </strong> 
<br>
<br>


Chiffre d'affaire: **{{$chiffre_affaire}}** <br>
Nombre de vente(s) : **{{$nb_vente}}**<br>
Nombre de filleul(s) parrainé(s) : **{{$nb_filleul}}**<br>


@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
