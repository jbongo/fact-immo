<table style="width: 50%">
    <tbody>
        <tr>
            <td style="width: 320px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="279" height="124" /></td>
            <td style="width: 380px;">
                @if($facture->destinataire_est_mandataire == true)
                    <p>  {{$facture->user->nom}} {{$facture->user->prenom}}</p>
                    <p>{{$facture->user->adresse}}</p> 
                    <p>{{$facture->user->code_postal}}, {{$facture->user->ville}}</p>

                @else

                    <p> {!! $facture->destinataire !!}  </p>
                @endif
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
            <td style="width: 443px;">&nbsp;</td>
            <td style="width: 344px;"><span style="text-decoration: underline;font-size:20px"><strong>FACTURE N&deg; {{$facture->numero}}</strong></span></td>
        </tr>
    </tbody>
</table>
<table style="height: 59px; width: 500px;">
    <tbody>
        <tr>
            <td style="width: 300px;"><span style="text-decoration: underline;"><strong>TRANSACTION</strong></span></td>
            <td style="width: 143px;"><span style="text-decoration: underline;"><strong>{{strtoupper($facture->type)}}</strong></span></td>
        </tr>
    </tbody>
</table>

<br>

<br>
<table style=" width: 100%">
    <tbody>
        <tr>
            <td style="width: 150px;">&nbsp;</td>
            <td style="width: 528px;"><span style="text-decoration: underline;"><strong>DESCRIPTION</strong> </td>
            <td style="width: 30px;">&nbsp;</td>
        </tr>
        
    </tbody>
</table>

<br>
<table style="height: 115px; width: 100%">
    <tbody>
        <tr>
            <td style="width: 150px;">&nbsp;</td>
            <td style="width: 528px;"><span style="">{!! $facture->description_produit !!} </td>
            <td style="width: 30px;">&nbsp;</td>
        </tr>
        
    </tbody>
</table>




<br>
<br>
<table style="height: 42px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 349px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>

            @if( $facture->destinataire_est_mandataire == true && $facture->user->contrat->est_soumis_tva == true)
                <td style="width: 117px; height: 25px;">{{number_format($facture->montant_ht * 1.2 ,2,',',' ')}} &euro; TTC</td>
            @else 
                <td style="width: 117px; height: 25px;">{{number_format($facture->montant_ht,2,',',' ')}} &euro; HT</td>
            @endif

            <td style="width: 177px; height: 25px;"> </td>
        </tr>
    </tbody>

</table>
<br>


<br>
<style>
    @page { margin: 50px 45px; }
    .footer {
        position: fixed;
        bottom: -15px;
        left: 0px; right: 0px;  height: 130px; 
        align-content: center;
    
    }
  
  </style>

<div class="footer">
    <table class="table table-striped table-bordered table-hover" style="width: 100%;"  border="1" cellspacing="0">
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
        <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE <br> Capital social: 3000 € - Carte professionnelle N°1312T14 TVA in FR 67 800738478 - SIRET: 800 738 478 00018 - RCS NIMES 800 738 478
        </p>
    </div>
</div>
   


