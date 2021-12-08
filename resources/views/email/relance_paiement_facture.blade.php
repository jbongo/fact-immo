@component('mail::message')
# Bonjour {{$facture->user->prenom}} {{$facture->user->nom}}

<br>
Sauf erreur ou omission de notre part, le paiement de la facture <strong> {{$facture->type}} {{$facture->numero}}</strong> ne nous est pas parvenu. <br><br>
Nous vous prions de bien vouloir procéder à son règlement dans les meilleurs délais, et vous adressons, à toutes fins utiles, un duplicata de cette facture en pièce jointe. <br><br>
Si par ailleurs votre paiement venait à nous parvenir avant la réception de la présente, nous vous saurions gré de ne pas en tenir compte.<br><br>





@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
