@component('mail::message')
# Bonjour 

@component('mail::panel')
    La TVA vient de passer de {{$ancienne_tva}}%  à {{$nouvelle_tva}}% <br>
  
@endcomponent

@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Message à destination de l'administrateur.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
