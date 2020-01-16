<table style="height: 80px; width: 712px;">
    <tbody>
    <tr style="height: 136px;">
    <td style="width: 489px; height: 136px;">
    <strong>{{$facture->compromis->user->prenom}} {{ strtoupper($facture->compromis->user->nom) }}</strong> <br>
    {{$facture->compromis->user->adresse}} <br>
    {{$facture->compromis->user->code_postal}} {{$facture->compromis->user->ville}} <br>
    @if($facture->compromis->user->siret != null ) SIRET {{$facture->compromis->user->siret}} @endif 
    <p>&nbsp;</p>
    <p>Dispens&eacute; d'immatriculation au registre du commerce et des soci&eacute;t&eacute;s (RCS) et au r&eacute;pertoire des m&eacute;tiers (RM)  ??</p> 
    </td>
    <td style="width: 211px; height: 136px;">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 77px; width: 711px;">
    <tbody>
    <tr>
    <td style="width: 368px;">&nbsp;</td>
    <td style="width: 333px;">
     <strong>SARL V4F&nbsp;</strong> <br>
     115 avenue de la Roquette ZA e Berret <br>
     30200 BAGNOLS SUR CEZE <br>
    <p>&nbsp;</p>
    <p> Le {{$facture->date_facture->format('d/m/Y')}}</p>
    </td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 50px; background-color: #d8dce1;" width="50%">
    <tbody>
    <tr>
    <td style="width: 229px;">&nbsp;</td>
    <td style="width: 230px; text-align: center;"><strong>FACTURE n&deg;<strong>{{$facture->numero}}</strong></td>
    <td style="width: 230px;">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table style="height: 94px;" width="70%">
    <tbody>
    <tr>
    <td style="width: 400px;">Commission {{$facture->compromis->type_affaire}}</td>
    <td style="width: 347px;">&nbsp;</td>
    </tr>
    <tr>
    <td style="width: 400px;">Mandat n&deg;{{$facture->compromis->numero_mandat}} du {{$facture->compromis->date_mandat->format('d/m/Y')}} - montant {{number_format($facture->compromis->frais_agence,'2',',',' ')}} &euro; TTC</td>
    <td style="width: 347px; text-align: center;">{{number_format($facture->montant_ttc,'2',',',' ')}} &euro;</td>
    </tr>
    <tr>
    <td style="width: 400px;">facture honoraires n&deg; F{{$facture->compromis->getFactureStylimmo()->numero}} du {{$facture->compromis->getFactureStylimmo()->date_facture->format('d/m/Y')}}</td>
    <td style="width: 347px;">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>


    <table style="width: 684px;">
    <tbody>
    <tr>
    <td style="width: 436px;">&nbsp;</td>
    <td style="width: 260px;"><strong>TOTAL HT&nbsp; &nbsp; &nbsp; {{number_format($facture->montant_ht,'2',',',' ')}}  &euro;</strong></td>
    </tr>
    @if( ($facture->compromis->user->statut == "auto-entrepeneur" && $facture->compromis->user->chiffre_affaire > 35200 ) || $facture->compromis->user->statut != "auto-entrepeneur")
    <tr>
        <td style="width: 436px;">&nbsp;</td>
        <td style="width: 260px;"><strong>TOTAL TTC&nbsp; &nbsp; &nbsp; {{number_format($facture->montant_ttc,'2',',',' ')}}  &euro;</strong></td>
    </tr>
    @endif
    @if($facture->compromis->user->statut == "auto-entrepeneur" && $facture->compromis->user->chiffre_affaire < 35200 )
    <tr>
    <td style="width: 436px;">&nbsp;</td>
    <td style="width: 260px;">TVA non applicable, art.293 B du CGI</td>
    </tr>
    @endif
    </tbody>
    </table>
    <p>&nbsp;</p>

    <div style="text-align: center; font-size: 14px; margin-right: 10%; margin-left: 10%; margin-top: 90px;">
        <p>    {{$facture->compromis->user->prenom}} {{ strtoupper($facture->compromis->user->nom) }} - @if($facture->compromis->user->siret != null ) SIRET {{$facture->compromis->user->siret}} @endif - {{$facture->compromis->user->adresse}} {{$facture->compromis->user->code_postal}} {{$facture->compromis->user->ville}}

        </p>
    </div>