@component('mail::message')
# Bonjour {{$mandataire->nom}} {{$mandataire->prenom}}

Vous trouverez en pièce jointe la facture 
@if($facture->type == "stylimmo")
STYL'IMMO 
@elseif($facture->type == "cci")
Attestation professionnelle (CCI) 
@elseif($facture->type == "forfait_entree")
Forfait d'entrée
@elseif($facture->type == "pack_pub")
Pack pub
@elseif($facture->type == "communication")
Communication
@endif
<span style="color:red">F{{$facture->numero}}</span>
<br>

@if($facture->type == "stylimmo")
    Mandat : {{$facture->compromis->numero_mandat}} <br>
    Date de vente prévue le : {{$facture->compromis->date_vente->format('d/m/Y')}} <br>
@endif

Bonne réception. <br>
Bien cordialement, <br>
L'Équipe STYL'IMMO.
<img src="{{asset('images/logo.jpg')}}" width="130px" height="65px" alt="logo">


@endcomponent
