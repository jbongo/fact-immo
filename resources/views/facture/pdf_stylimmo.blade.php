<table style="width: 50%">
        <tbody>
            <tr>
                <td style="width: 320px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="279" height="124" /></td>
                <td style="width: 380px;">
                    @if ($compromis->charge == "Vendeur")
                       
                            <p><strong>{{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} </strong></p> 
                       
                            <p>{{$compromis->adresse1_vendeur}}</p>
                            <p>{{$compromis->adresse2_vendeur}} &nbsp;</p> 
                            <p>{{$compromis->code_postal_vendeur}} {{$compromis->ville_vendeur}}</strong></p>
                            
                    @else 

                      
                            <p> {{$compromis->civilite_acquereur}} {{$compromis->nom_acquereur}} </p>                
                       
                        <p>{{$compromis->adresse1_acquereur}} </p>
                        <p>{{$compromis->adresse2_acquereur}} </p>
                        <p> {{$compromis->code_postal_acquereur}}, {{$compromis->ville_acquereur}}</strong></p>
                        

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
                <td style="width: 443px;"><span style="color: #ff0000;">Merci d'indiquer le num&eacute;ro de facture en r&eacute;f&eacute;rence du virement.</span></td>
                <td style="width: 344px;"><span style="text-decoration: underline;font-size:20px"><strong>FACTURE N&deg; {{$facture->numero}}</strong></span></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 59px; width: 500px;">
        <tbody>
            <tr>
                <td style="width: 300px;"><span style="text-decoration: underline;"><strong>COMMISSION SUR TRANSACTION</strong></span></td>
                <td style="width: 143px;"><span style="text-decoration: underline;"><strong>{{strtoupper($compromis->type_affaire)}}</strong></span></td>
            </tr>
        </tbody>
    </table>
@if($compromis->type_affaire == "Vente")
    <table style="height: 26px; width: 50%;">
        <tbody>
            <tr>
                <td style="width: 350px;">En l'&eacute;tude de Scp&nbsp; {{$compromis->scp_notaire}}</td>
                <td style="width: 350px;">&nbsp; </td>
                {{-- Pr&eacute;vue pour le : {{ Carbon\Carbon::parse($compromis->date_vente)->format('d/m/Y')}} --}}
            </tr>
        </tbody>
    </table>
@endif
@if($compromis->type_affaire == "Location")
<table style="height: 26px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 423px;">&nbsp; </td>
            <td style="width: 260px;"> date entrée : {{ Carbon\Carbon::parse($compromis->user->date_entree)->format('d/m/Y')}}   </td>
        </tr>
    </tbody>
</table>
@endif
    <table style="height: 37px; width: 50%;">
        <tbody>
            <tr>
                <td style="width: 350px;"><span style="text-decoration: underline;"><strong>R&eacute;f.</strong></span><strong>:&nbsp;</strong>&nbsp; Mandat N&deg;&nbsp; {{$compromis->numero_mandat}}&nbsp; du : {{ Carbon\Carbon::parse($compromis->date_mandat)->format('d/m/Y')}}</td>
                <td style="width: 350px;">Affaire suivie par : {{$mandataire->nom}} {{$mandataire->prenom}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table style="height: 40px; ">
        <tbody>
            <tr>
                <td style="width: 48px;">&nbsp;</td>
                <td style=""><span style="text-decoration: underline; font-weight:bold"> @if($compromis->type_affaire == "Vente") Vendeur(s) @else Propriétaire(s)@endif: </span> {{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} </td>
                {{-- <td style="width: 391px;">&nbsp;</td> --}}
            </tr>

        </tbody>
    </table>

    <table style="height: 63px; ">
        <tbody>
            <tr>
                <td style="width: 48px;">&nbsp;</td>
                <td style=""><span style="text-decoration: underline; font-weight:bold">@if($compromis->type_affaire == "Vente") Acquéreur(s) @else Locataire(s)@endif:</span> {{$compromis->civilite_acquereur}}   {{$compromis->nom_acquereur}} </strong></td>
                {{-- <td style="width: 391px;">&nbsp;</td> --}}
            </tr>
        </tbody>
    </table>

    <table style="height: 63px; width:90% ">
        <tbody>
            <tr>
                <td style="width: 48px;">&nbsp;</td>
                <td style=""><span style="text-decoration: underline;"><strong>Description du bien :</strong></span></td>
                {{-- <td style="width: 391px;"></td> --}}
    
            </tr>
            <tr style="">
                <td style="width: 48px;">&nbsp;</td>
                <td style=" ">{{substr($compromis->description_bien, 0,200)}}  </td>
                {{-- <td style="width: 391px;"></td> --}}
    
            </tr>
        </tbody>
    </table>
    <br><br>
    <table style="height: 47px; width: 672px;">
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
    </table>
    <br>

    <table style="height: 30px; width: 50%;">
        <tbody>
            <tr style="height: 25px;">
                <td style="width: 300px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
                <td style="width: 200px; height: 25px;">{{number_format($compromis->frais_agence,2,'.',' ')}} &euro; TTC</td>
                <td style="width: 187px; height: 25px;"><span style="color: #ff0000; font-size:18px; font-weight:bold">&nbsp;R&eacute;f &agrave; rappeler: {{$facture->numero}}</span></td>
            </tr>
        </tbody>
    
    </table>
    <br>
 
    {{-- @if($compromis->type_affaire == "Vente") --}}
    <table style="height: 40px; ">
        <tbody>
            <tr>
                <td style="width: 170px;">
                 
                    <div><span style="text-decoration: underline;"><strong>Conditions de paiement:</strong></span></div>
                    
                </td>
                <td style="width: 488px;  font-size: 12px;">
                   
                    <div>Au plus tard le jour de la signature de l'acte authentique, par virement &agrave; <br> la SARL&nbsp;{{App\Parametre::params()->raison_sociale}}, en rappelant au moins sur l'objet du virement les r&eacute;f&eacute;rences de la facture.</div>
                    
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
    {{-- @endif --}}
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
            <p><strong>SARL {{App\Parametre::params()->raison_sociale}}</strong> - {{App\Parametre::params()->adresse}}   - Zone Artisanale de Berret - {{App\Parametre::params()->code_postal}}   {{App\Parametre::params()->ville}}   <br> Capital social: 3000 € - Carte professionnelle N°1312T14 TVA in FR {{App\Parametre::params()->numero_tva}}   - SIRET: {{App\Parametre::params()->numero_siret}} - RCS NIMES {{App\Parametre::params()->numero_rcs}}
            </p>
        </div>
</div>
       

    
    