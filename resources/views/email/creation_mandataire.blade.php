@component('mail::message')
# Bonjour {{$mandataire->prenom}} {{$mandataire->nom}}

Félicitation vous pouvez maintenant vous connecter sur l'outil de facturation : <a href="{{config('app.url')}}">Cliquez ici</a> pour vous connecter<br>
Login : {{$mandataire->email}} <br>
Mot de passe : {{$password}} <br>

@if($path_contrat != null && $path_annexe != null)
    Vous trouverez en pièce jointe les fichiers ci-dessous: 
    - <strong>Contrat STYL'IMMO</strong>
    - <strong>Annexes au Contrat </strong>
    @if($path_cci != null)
    - <strong>Facture Attestation de Collaborateur (CCI)</strong>
    @endif
    @if($path_forfait != null)
    - <strong>Facture Forfait d'entrée</strong>
    @endif
@endif

@component('mail::button', ['url' => config('app.url') ])
Se connecter
@endcomponent

Bien cordialement,<br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">

@endcomponent
