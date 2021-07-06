@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}}

Sauf erreur ou omission de notre part, le paiement de la facture {{$facture->numero}}, ne nous est pas parvenu.
Nous vous prions de bien vouloir procéder à son règlement dans les meilleurs délais, et vous adressons, à toutes fins utiles, un duplicata de cette facture en pièce jointe.
Si par ailleurs votre paiement venait à nous parvenir avant la réception de la présente, nous vous saurions gré de ne pas en tenir compte.<br>





@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
