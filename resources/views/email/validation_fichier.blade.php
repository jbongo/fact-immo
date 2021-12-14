@component('mail::message')
# Bonjour {{$fichier->user->prenom}} {{$fichier->user->nom}}

@if($fichier->valide == 2)

Votre document <strong> {{$fichier->document->nom}}</strong> a été refusé. <br>
@component('mail::panel')
Motif: {{$fichier->motif_refu}} <br>  
@endcomponent
Veuillez rajouter le bon fichier. 

@endif

@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
