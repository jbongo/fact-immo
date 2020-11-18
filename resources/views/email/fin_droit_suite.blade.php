@component('mail::message')
# Bonjour {{$contrat->user->prenom}} {{$contrat->user->nom}}


@component('mail::panel')
    Vous êtes arrivé à terme de vos droits de suite après votre démission du {{$contrat->date_demission->format('d/m/Y')}}. <br>
   <strong>  Vous n'avez donc plus accès au minicurieux.</strong>
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
