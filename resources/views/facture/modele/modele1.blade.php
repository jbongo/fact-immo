        <table style="width: 50%">
            <tbody>
            <tr>
            <td style="width: 693px;">
            <div style="text-align: center;">&eacute;{{$facture->compromis->user->prenom}} {{ strtoupper($facture->compromis->user->nom) }}</div>
            <div style="text-align: center;">&nbsp;</div>
            <div style="text-align: center;">{{$facture->compromis->user->adresse}}</div>
            <div style="text-align: center;">{{$facture->compromis->user->code_postal}} {{$facture->compromis->user->ville}}</div>
            <div style="text-align: center;">  @if($facture->compromis->user->numero_tva != null  )N&deg; T VA {{$facture->compromis->user->numero_tva}} @endif</div>
            <div style="text-align: center;">@if($facture->compromis->user->siret != null ) SIRET {{$facture->compromis->user->siret}} @endif</div>
            </td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>

            <table style="width: 50%" height="150px">
            <tbody>
            <tr>
            <td style="width: 228px;">&nbsp;</td>
            <td style="width: 228px;">
            <div style="text-align: center;"><span style="text-decoration: underline;"><strong>H O N O R A I R E S</strong></span></div>
            </td>
            <td style="width: 228px;">&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>

            <table style="width: 50%">
            <tbody>
            <tr>
            <td style="width: 64px;"><strong>Facture n&deg; :  </strong><strong>{{$facture->numero}}</strong></td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>
            {{-- CLIENT --}}
            <table style="height: 80px;" width="500">
                <tbody>
                    <tr style="height: 25px;">
                    <td style="width: 25px; height: 25px;">
                        Client :   
                    </td>
                    <td style="width: 230px; height: 25px;">
                    <div>
                    <div style="text-align: center;">SARL&nbsp;{{App\Parametre::params()->raison_sociale}}</div>
                    </div>
                    </td>
                    <td style="width: 230px; height: 25px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 25px;">
                    <td style="width: 25px; height: 25px;">&nbsp;</td>
                    <td style="width: 230px; height: 25px;">
                    <div>
                    <div style="text-align: center;">115&nbsp;Avenue&nbsp;de&nbsp;la&nbsp;Roquette</div>
                    </div>
                    </td>
                    <td style="width: 230px; height: 25px;">&nbsp;</td>
                    </tr>
                    <tr style="height: 25px;">
                    <td style="width: 25px; height: 25px;">&nbsp;</td>
                    <td style="width: 230px; height: 25px;">
                    <div>
                    <div style="text-align: center;">&nbsp;30&nbsp;200&nbsp;BAGNOLS&nbsp;SUR&nbsp;CEZE</div>
                    </div>
                    </td>
                    <td style="width: 230px; height: 25px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <table height="100px" style="width: 50%">
            <tbody>
            <tr>
            <td style="width: 697px;" colspan="2">
            <p><strong>Date :</strong>&nbsp; &nbsp; &nbsp; {{$facture->date_facture->format('d/m/Y')}}</p>
            </td>
            </tr>
            </tbody>
            </table>
{{-- DESIGNATION --}}
            <table style="height: 90px; width: 50%">
            <tbody>
            <tr>
            <td style="width: 468px;">
                <span style="text-decoration: underline;"><strong> D&eacute;signation de l'op&eacute;ration </strong></span>
            </td>
            <td style="width: 229px; font-size:20px">{{ ucfirst($facture->type)}}</td>
            </tr>
            </tbody>
            </table>
           
            
            <table style="height: 70px;" width="100%">
            <tbody>
            <tr style="height: 19px;">
            <td style="width: 693px; height: 19px;">
            Ref : F {{$facture->compromis->getFactureStylimmo()->numero}} &nbsp; du : {{$facture->compromis->getFactureStylimmo()->date_facture->format("d/m/Y")}}
            </td>
            </tr>
           
            <td style="width: 693px; height: 18px;">
            <p>Mandat N&deg; {{$facture->compromis->numero_mandat}} &nbsp; du : {{$facture->compromis->date_vente->format("d/m/Y")}} &nbsp; par : {{$facture->compromis->user->prenom}} {{$facture->compromis->user->nom}}</p>
            </td>
            </tr>
            </tbody>
            </table>
       
            {{-- COMMISSION --}}
            <table style="height: 50px; width: 703px;">
            <tbody>
            <tr>
                @if($facture->type == "parrainage")

                    <td style="width: 191px; text-align: center;">&nbsp;Commission : {{number_format($facture->compromis->montant_ttc,'2','.',' ')}} TTC&nbsp;</td>
                @elseif($facture->type == "partage")
                    <td style="width: 250px; text-align: center;">&nbsp;Commission : {{number_format($facture->montant_ttc,'2','.',' ')}} TTC&nbsp;</td>

                @elseif($facture->type == "parrainage_partage")
                <td style="width: 250px; text-align: center;">&nbsp;Commission : {{number_format($facture->montant_ttc,'2','.',' ')}} TTC&nbsp;</td>

                
                @elseif($facture->type == "honoraire")
                    {{-- @foreach ($formule[0] as $key=>$formu) --}}
            
                        {{-- <td style="width: 400px;">&nbsp;</td> --}}
                        {{-- <td style="width: 191px; text-align: center;">{{$key+1}} &nbsp; :</td> --}}

                        @if($facture->user->statut != "auto-entrepreneur" || ($facture->user->statut == "auto-entrepreneur" && $facture->user->chiffre_affaire >= 35200) )
                            <td style="width: 250px; text-align: center;">&nbsp;Commission : {{number_format($facture->montant_ttc,'2','.',' ')}} TTC&nbsp;</td>
                        @else 
                            <td style="width: 250px; text-align: center;">&nbsp;Commission : {{number_format($facture->montant_ht,'2','.',' ')}} HT&nbsp;</td>
                        @endif    
                    {{-- @endforeach --}}
                @endif
                <br>
            </tr>
            </tbody>
            </table>
         
            {{-- TVA --}}
            <table style="height: 33px; width: 703px;">
            <tbody>
            <tr>
            <td style="width: 185px; text-align: center;">&nbsp;Total Hors Taxes d&ucirc; : &hellip;............&nbsp;{{number_format($facture->montant_ht,'2','.',' ')}} &euro;&nbsp;</td>
            </tr>
            
            @if($facture->user->statut != "auto-entrepreneur" || ($facture->user->statut == "auto-entrepreneur" && $facture->user->chiffre_affaire >= 35200) )
            <tr style="text-align: center;">
            <td style="width: 185px;">&nbsp;Imputation T.V.A : 20%&nbsp;: &hellip;..........&nbsp;{{number_format($facture->montant_ttc - $facture->montant_ht,'2','.',' ')}} &euro;&nbsp;</td>
            </tr>
            @endif

            </tbody>
            </table>

            {{-- MONTANT TTC --}}
            <table style="height: 50px; width: 700px;">
            <tbody>
            <tr>
            @if($facture->user->statut != "auto-entrepreneur" || ($facture->user->statut == "auto-entrepreneur" && $facture->user->chiffre_affaire >= 35200) )
                <td style="width: 182px; text-align: center;">&nbsp;<strong>SOIT UN TOTAL T.T.C : {{number_format($facture->montant_ttc,'2','.',' ')}} &euro;</strong>&nbsp;</td>
            @else 
                <td style="width: 182px; text-align: center;">&nbsp;<strong>SOIT UN TOTAL H.T: {{number_format($facture->montant_ht,'2','.',' ')}} &euro;</strong>&nbsp;</td>
            @endif
            </tr>
            </tbody>
            </table>
 
<div style="text-align: center; font-size: 11px; margin-right: 10%; margin-left: 10%; margin-top: 90px;">
    <p><strong>SARL {{App\Parametre::params()->raison_sociale}}</strong> - {{App\Parametre::params()->adresse}}   - Zone Artisanale de Berret - {{App\Parametre::params()->code_postal}}   {{App\Parametre::params()->ville}}   Carte professionnelle N°1312T14 TVA {{App\Parametre::params()->numero_tva}}   - SIRET: {{App\Parametre::params()->numero_siret}} - RCS NIMES {{App\Parametre::params()->numero_rcs}}
    </p>
</div>