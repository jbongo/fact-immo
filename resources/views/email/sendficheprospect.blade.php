@component('mail::message')
# Bonjour {{$prospect->prenom}} {{$prospect->nom}}

Une petite démarche avant de rentrer dans le vif du sujet. <br>
Merci de completer votre fiche d'info:  <br>



@component('mail::button', ['url' => $url])
Je renseigne ma fiche d'info
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent