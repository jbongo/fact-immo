@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}},


@if(sizeof($documents) > 1)
Vos documents ci-dessous ont expiré, veuillez les remplacer et modifier les dates d'expiration :<br>
@else 
Votre document ci-dessous a expiré, veuillez le remplacer et modifier la date d'expiration :<br>


@endif
<strong>Non document / Date d'expiration</strong>
@component('mail::panel')
@foreach ($documents as $document)
<li style="color: #990404">  {{$document->document->nom}} / {{$document->date_expiration->format('d-m-Y')}} </li>   
@endforeach
@endcomponent

Pour modifier un document : 
- Connectez-vous sur le minicurieux
- Allez dans l'onglet "Mes documents"
- Modifiez votre document et sa date d'expiration 
- Cliquez sur le bouton "Enregistrer"
<br><hr>


@component('mail::button', ['url' => config('app.url') ])
Se connecter 
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
