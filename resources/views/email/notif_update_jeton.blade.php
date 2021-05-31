@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


Vous êtes arrivés à votre date d'anniversaire de début d'activité le : **({{$mandataire->contrat->date_deb_activite->format('d/m/Y')}})**. <br>

@component('mail::panel')
Vos jetons sont incrémentés de <strong> 12 </strong><br><hr>
Vous avez maintenant:  <strong> **{{$mandataire->nb_mois_pub_restant}}** </strong> jetons <br>


@endcomponent

<br>

<br>





@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
