@extends('layouts.app')

@section('content')


<br><br>


    @section ('page_title')

    <a class=" btn btn-danger " title="Télécharger " href="{{route('facture.telecharger_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">Télecharger  <i class="ti-download"></i> </a>

 @endsection


 <style type="text/css">
    body {
        background-color:#fff;
    }
    </style>

<table style="width: 50%">
    <tbody>
        <tr>
            <td style="width: 320px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="279" height="124" /></td>
            <td style="width: 380px;">
             
                    <p> {{$facture->user->nom}} {{$facture->user->prenom}}</p>
                    <p>{{$facture->user->adresse}}</p> 
                    <p>{{$facture->user->code_postal}}, {{$facture->user->ville}}</p>

            </td>
        </tr>
    </tbody>
</table>
<table style="height: 30px; width: 20%">
    <tbody>
        <tr>
            <td style="width: 216px;">Bagnols sur C&egrave;ze, le @if($facture->date_facture != null) {{$facture->date_facture->format('d/m/Y')}} @else{{$facture->created_at->format('d/m/Y')}}  @endif</td>
            {{-- <td style="width: 194px;"></td> --}}
        </tr>
    </tbody>
</table>
<br>


<table style="height: 53px;" width="50%">
    <tbody>
        <tr>
            <td style="width: 443px;"><span style="color: #ff0000;">Merci d'indiquer le num&eacute;ro de facture en r&eacute;f&eacute;rence du virement.</span></td>
            <td style="width: 344px;"><span style="text-decoration: underline;font-size:20px"><strong>FACTURE N&deg; {{$facture->numero}}</strong></span></td>
        </tr>
    </tbody>
</table>
{{-- <table style="height: 59px; width: 500px;">
    <tbody>
        <tr>
            <td style="width: 300px;"><span style="text-decoration: underline;"><strong>TRANSACTION</strong></span></td>
            <td style="width: 143px;"><span style="text-decoration: underline;"><strong>{{strtoupper($facture->type)}}</strong></span></td>
        </tr>
    </tbody>
</table> --}}
<br>
<table style="height: 30px; width: 50%;">
    <tbody>
    <tr style="height: 18px;">
        <td style="width: 200px; height: 18px;"><strong>Période de : {{$mois}}</strong></td>
        <td style="width: 300px; height: 18px;"> </td>
        <td style="width: 187px; height: 18px;"></td>
    </tr>
    </tbody>
</table>

<br><br>

<table style="height: 30px; width: 50%;">
    <tbody>
    <tr style="height: 18px;">
        <td style="width: 200px; height: 18px;"><strong>Outils informatique</strong></td>
        <td style="width: 300px; height: 18px;"> </td>
        <td style="width: 187px; height: 18px;"> H.T: {{$facture->user->contrat->forfait_pack_info}} &euro; </td>
    </tr>
    </tbody>
</table>
    
<table style="border-collapse: collapse; width: 100%; height: 18px;" >
    <tbody>
    <tr style="height: 18px;">
    <td style="width: 500px; height: 18px;"><img src="/images/logiciel.png" alt="" /></td>
    <td style="width: 187px; height: 18px;">
    
  
    
    </td>

</tr>
</tbody>
</table>
<br>

{{-- <p style="text-align: left;"></p> --}}

@if($facture->montant_ht > $facture->user->contrat->forfait_pack_info)

<table style="height: 30px; width: 50%;">
    <tbody>
    <tr style="height: 18px;">
        <td style="width: 200px; height: 18px;"><strong>Passerelles dans votre Pac</strong></td>
        <td style="width: 300px; height: 18px;"> </td>
        <td style="width: 187px; height: 18px;"> H.T: {{$facture->montant_ht - $facture->user->contrat->forfait_pack_info}}&euro; </td>
    </tr>
    </tbody>
</table>
    



<table style="border-collapse: collapse; width: 100%; height: 18px;" >
    <tbody>
    <tr style="height: 18px;">
    <td style="width: 500px; height: 18px;"><img src="/images/passerelle_abon.png" width= "500px" height="200px" alt="" /></td>
    <td style="width: 187px%; height: 18px;">
    <p>&nbsp;</p>
    <p></p>
    <p>&nbsp;</p>
    </td>
    </tr>
    </tbody>
</table>

@endif

<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 50%; height: 18px;" >
<tbody>
<tr style="height: 18px;">
<td style="width: 33.3333%; height: 18px;">T H.T:&nbsp; {{$facture->montant_ht}} €</td>
<td style="width: 33.3333%; height: 18px;">T.V.A 20%: {{$facture->montant_ht * 0.2}} €</td>
<td style="width: 33.3333%; height: 18px;">TOTAL T.T.C: {{$facture->montant_ttc}} €</td>
</tr>
</tbody>
</table>
<br><br>


{{-- <table style="height: 47px; width: 672px;">
    <tbody>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 160px;">TOTAL H.T :</td>
            <td style="width: 100px; text-align:right;" >{{number_format($facture->montant_ht,2,',',' ')}} &euro;</td>
        </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 160px;">T.V.A 20% :</td>
            <td style="width: 100px; text-align:right;" >{{number_format($facture->montant_ht * App\Tva::tva(),2,',',' ')}} &euro;</td>
        </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 160px;">TOTAL T.T.C:</td>
            <td style="width: 100px; text-align:right;" >{{number_format($facture->montant_ttc,2,',',' ')}} &euro;</td>
        </tr>
    </tbody>
</table> --}}
<br>

<table style="height: 30px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 300px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
            <td style="width: 200px; height: 25px;">{{number_format($facture->montant_ttc,2,'.',' ')}} &euro; TTC</td>
            <td style="width: 187px; height: 25px;"><span style="color: #ff0000; font-size:18px; font-weight:bold">&nbsp;R&eacute;f &agrave; rappeler: {{$facture->numero}}</span></td>
        </tr>
    </tbody>

</table>
<br>


  
  <div class="footer">
    <table style="height: 40px; ">
        <tbody>
            <tr>
                <td style="width: 170px;">
                 
                    <div><span style="text-decoration: underline;"><strong>Conditions de paiement:</strong></span></div>
                    
                </td>
                <td style="width: 488px;  font-size: 12px;">
                   
                    <div>A réception, par virement &agrave; la SARL&nbsp;{{App\Parametre::params()->raison_sociale}}, <br>en rappelant au moins sur l'objet du virement les r&eacute;f&eacute;rences de la facture.</div>
                    
                </td>
            </tr>
            <tr>
                <td style="width: 170px;">
                 
                    <div><span style="text-decoration: underline;"><strong>Intérêts de retard:</strong></span></div>
                    
                </td>
                <td style="width: 488px;  font-size: 12px;">
                   
                    <div> Au taux d'intérêt légal</div>
                    
                </td>
            </tr>
            <tr>
                <td style="width: 300px;">
                 
                    <div><span style="text-decoration: underline;"><strong>Indemnité forfaitaire de recouvrement: </strong></span></div>
                    
                </td>
                <td style="width: 158px;  font-size: 12px;">
                   
                    <div>40 €</div>
                    
                </td>
            </tr>
        </tbody>
    </table>

<br>


    <table class="table table-striped table-bordered table-hover" style="width: 50%;"  border="1" cellspacing="0">
        <thead>
            <tr style="height: 18px;">
                <th align="center" style="height: 18px;">DOMICILIATION BANCAIRE: Crédit Mutuel</th>
            </tr>
        </thead>
        <tbody>
            <tr style="height: 18px;">
                <th align="center" style="height: 18px;">RIB: 10278 7941 00020227203 08</th>
            </tr>
            <tr style="height: 18px;">
                <th align="center">IBAN: FR76102 78079 41000 2022 720308</th>
            </tr>
            <tr style="height: 8px;">
                <th align="center" style="height: 8px;">BIC: CMCIFR2A</th>
            </tr>
        </tbody>
    </table> 
    <div style="text-align: center; font-size: 11px; margin-right: 5%; margin-left: 5%; ">
        <p><strong>SARL {{App\Parametre::params()->raison_sociale}}</strong> - {{App\Parametre::params()->adresse}}   - Zone Artisanale de Berret - {{App\Parametre::params()->code_postal}}   {{App\Parametre::params()->ville}}   <br> Capital social: 3000 € - Carte professionnelle N°1312T14 TVA in FR {{App\Parametre::params()->numero_tva}}   - SIRET: {{App\Parametre::params()->numero_siret}} - RCS NIMES {{App\Parametre::params()->numero_rcs}}
        </p>
    </div>
</div>
   


@endsection