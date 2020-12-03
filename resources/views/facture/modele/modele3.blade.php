<table style="height: 89px;" width="712">
    <tbody>
    <tr>
    <td style="width: 348px;">
    <div><span style="color: #3366ff;"><strong>{{strtoupper($facture->compromis->user->prenom)}} {{ strtoupper($facture->compromis->user->nom) }}</strong></span></div>
    <div>&nbsp;</div>
    <div><span style="color: #3366ff;">Conseiller en Immobilier</span></div>
    <div><span style="color: #3366ff;">{{$facture->compromis->user->telephone1}}</span></div>
    
    
    </td>
    <td style="width: 348px;">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    <table style="height: 107px;" width="708">
    <tbody>
    <tr>
    <td style="width: 346px;">&nbsp;</td>
    <td style="width: 346px;">
    <div><strong>Sarl {{App\Parametre::params()->raison_sociale}}</strong></div>
    <div>&nbsp;</div>
    <div>{{App\Parametre::params()->adresse}}  </div>
    <div>30 200 &ndash; {{App\Parametre::params()->ville}}  </div>
    </td>
    </tr>
    </tbody>
    </table>
  <br>
    <table style="height: 41px;" width="707">
    <tbody>
    <tr>
    <td style="width: 697px; font-size:25px"><strong>Facture n&deg; : {{$facture->numero}}</strong></td>
    </tr>
    <tr>
    <td style="width: 697px;">DATE: {{$facture->date_facture->format('d/m/Y')}}</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 26px;" width="706">
    <tbody>
    <tr>
    <td style="width: 696px;">
    <div><strong>N&deg; de mandat : {{$facture->compromis->numero_mandat}} &ndash; Facture Stylimmo N&deg; {{$facture->compromis->getFactureStylimmo()->numero}} &nbsp; du {{$facture->compromis->getFactureStylimmo()->date_facture->format('d/m/Y')}}</strong></div>
    </td>
    </tr>
    <tr>
    <td style="width: 696px;">
    <div><strong>Vendeur : {{$facture->compromis->nom_vendeur}} / Acqu&eacute;reur : {{$facture->compromis->nom_acquereur}} / Notaire&nbsp;{{$facture->compromis->scp_notaire}}</strong></div>
    </td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 66px;" width="50%" border="1" cellspacing="0">
    <tbody>
    <tr>
    <td style="width: 170px; text-align: center;"><strong>NOM VENDEUR</strong></td>

    <td style="width: 165px; text-align: center;"><strong>COMMISSION&nbsp;TOTALE</strong></td>
    <td style="width: 165px; text-align: center;">
      <strong>TAUX DE</strong>    
      <strong>COMMISSIONNEMENT&nbsp;</strong>   
    </td>
    <td style="width: 165px; text-align: center;"><strong>MODE DE&nbsp;PAIEMENT</strong></td>
    </tr>
    <tr>
    <td style="width: 170px;">{{$facture->compromis->nom_vendeur}}</td>
    <td style="width: 165px;">{{number_format($facture->compromis->frais_agence,'2',',',' ')}} TTC</td>
    <td style="width: 165px;">{{$facture->user->commission }}%</td>
    <td style="width: 165px;">RIB</td>
    </tr>
    </tbody>
    </table>
    <br>
    <div>
    <table style="height: 80px; width: 50%;" border="1" cellspacing="0">
    <tbody>
    <tr>
    <td style="width: 100px;">
    <div><strong>QUANTITES</strong></div>
    </td>
    <td style="width: 244px;">
    <div><strong>DESIGNATION</strong></div>
    </td>
    <td style="width: 166px;">
    <div><strong>P.U.H.T.</strong></div>
    </td>
    <td style="width: 166px;"><strong>MONTANT H.T</strong></td>
    </tr>
    <tr>
    <td style="width: 100px;">
    <p>&nbsp;</p>
    <p style="text-align: center;">1</p>
    <p>&nbsp;</p>
    </td>
    <td style="width: 244px;">Commission sur {{number_format($facture->compromis->frais_agence,'2',',',' ')}} de frais d'agence = {{number_format($facture->montant_ht,'2',',',' ')}} HT</td>
    <td style="width: 166px;">{{number_format($facture->montant_ht,'2',',',' ')}}</td>
    <td style="width: 166px;">{{number_format($facture->montant_ht,'2',',',' ')}}</td>
    </tr>
    <tr>
    <td style="width: 136px;" colspan="2" rowspan="4">&nbsp;</td>
    <td style="width: 166px;">
    <div>TOTAL H.T.</div>
    </td>
    <td style="width: 166px;">{{number_format($facture->montant_ht,'2',',',' ')}}</td>
    </tr>
    @if( ($facture->compromis->user->statut == "auto-entrepeneur" && $facture->compromis->user->chiffre_affaire >= 35200 ) || $facture->compromis->user->statut != "auto-entrepeneur")

    <tr>
    <td style="width: 166px;">T.V.A. 20 %</td>
    <td style="width: 166px;">
    <p>{{number_format($facture->montant_ttc - $facture->montant_ht,'2',',',' ')}}</p>
   
    </td>
    </tr>

    <tr>
    <td style="width: 166px;">TOTAL T.T.C</td>
    <td style="width: 166px;">
    <div>{{number_format($facture->montant_ttc,'2',',',' ')}}</div>
    </td>
    </tr>

    @endif
    </tbody>
    </table>
    </div>
  <br>
    <div>
    <table style="height: 11px;" width="688">
    <tbody>
    <tr>
    <td style="width: 678px; text-align: center;">Valeur en votre aimable r&egrave;glement</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
 
    {{-- <table style="height: 5px;" width="687">
    <tbody>
    <tr>
    <td style="width: 677px;">
    <div style="text-align: center;">1 parc de chatenay - 38540 &ndash; Heyrieux&nbsp;N&deg;siret : 3&nbsp;24 830 447 00037 / code APE 6831 ZTVA</div>
    <div style="text-align: center;">INTRACOMMUNAUTAIRE : FR 593 248 304 47</div>
    </td>
    </tr>
    </tbody>
    </table> --}}
   
    </div>

    <div style="text-align: center; font-size: 14px; margin-right: 10%; margin-left: 10%; margin-top: 90px;">
        <p>    
            {{$facture->compromis->user->adresse}} {{$facture->compromis->user->code_postal}} {{$facture->compromis->user->ville}}@if($facture->compromis->user->siret != null ) SIRET {{$facture->compromis->user->siret}} @endif  

        </p>
    </div>