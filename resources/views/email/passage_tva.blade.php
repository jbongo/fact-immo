@component('mail::message')
# Bonjour {{$mandataire->nom}}, {{$mandataire->prenom}}

@component('mail::panel')
    Vous venez de passer à la TVA. <br>
    N'oubliez pas de fournir par mail votre numéro de TVA. <br>
  
@endcomponent

@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent


<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
