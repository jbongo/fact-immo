@component('mail::message')
# Bonjour {{$facture->user->prenom}} {{$facture->user->nom}}

@if($facture->statut == "refuse")

Votre facture <strong> {{$facture->numero}}</strong> a été refusée. <br>
Contactez l'administrateur pour plus d'informations.
@else

Votre facture <strong> {{$facture->numero}}</strong> a été acceptée. <br>


@endif

@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
