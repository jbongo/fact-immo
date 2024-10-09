@component('mail::message')
# Bonjour {{$mandataire->nom}} {{$mandataire->prenom}}

{{-- Vous trouverez en pièce jointe la facture  --}}
@if($facture->type == "stylimmo")
STYL'IMMO 
@elseif($facture->type == "cci")
{{-- Attestation de Collaborateur (CCI)  --}}
Après vérification, une erreur a été constatée dans le numéro de la facture CCI précédemment envoyée. <br>

Veuillez trouver ci-joint la version corrigée de la facture.<br>
Nous vous prions de bien vouloir ne pas prendre en compte la version initiale.<br>

Nous restons à votre disposition pour toute question. <br>
@elseif($facture->type == "forfait_entree")
Forfait d'entrée
@elseif($facture->type == "pack_pub")
Pack pub
@elseif($facture->type == "communication")
Communication
@endif
{{-- <span style="color:red">F{{$facture->numero}}</span> --}}
<br>

@if($facture->type == "stylimmo")
Mandat : <strong>  {{$facture->compromis->numero_mandat}}</strong> <br>
Date de vente prévue le : <strong>  {{$facture->compromis->date_vente->format('d/m/Y')}}</strong> <br>
@endif

Bonne réception. <br>
Bien cordialement, <br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">


@endcomponent
