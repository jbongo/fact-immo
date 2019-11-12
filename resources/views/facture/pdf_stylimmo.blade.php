<table style="width: 50%">
        <tbody>
            <tr>
                <td style="width: 482px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="219" height="114" /></td>
                <td style="width: 437px;">
                    @if ($compromis->charge == "Vendeur")
                        @if ($compromis->civilite_vendeur == "M." || $compromis->civilite_vendeur == "Mme")
                            <p>{{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} {{$compromis->prenom_vendeur}}</p>
                        @else 
                            <p>{{$compromis->civilite_vendeur}} {{$compromis->raison_sociale_vendeur}} </p>                        
                        @endif
                            <p><strong>{{$compromis->adresse1_vendeur}},</strong></p> 
                            <p><strong>{{$compromis->code_postal_vendeur}}, {{$compromis->ville_vendeur}},</strong></p>
                            <p><strong>{{$compromis->adresse2_vendeur}}</strong></p>
                    @else 

                        @if ($compromis->civilite_acquereur == "M." || $compromis->civilite_acquereur == "Mme")
                            <p> {{$compromis->civilite_acquereur}} {{$compromis->nom_acquereur}} {{$compromis->prenom_acquereur}}</p>                
                        @else 
                            <p> {{$compromis->civilite_acquereur}} {{$compromis->raison_sociale_acquereur}} </p>                        
                        @endif
                        <p><strong>{{$compromis->adresse1_acquereur}},</strong> </p>
                        <p><strong> {{$compromis->code_postal_acquereur}}, {{$compromis->ville_acquereur}},</strong></p>
                        <p><strong>{{$compromis->adresse2_acquereur}},</strong> </p>

                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 91px; width: 20%">
        <tbody>
            <tr>
                <td style="width: 216px;">Bagnols sur C&egrave;ze, le</td>
                <td style="width: 194px;">{{Carbon\Carbon::now()->format('d/m/Y')}}</td>
            </tr>
        </tbody>
    </table>
    <table style="height: 53px;" width="50%">
        <tbody>
            <tr>
                <td style="width: 443px;"><span style="color: #ff0000;">Merci d'indiquer le num&eacute;ro de facture en r&eacute;f&eacute;rence du virement.</span></td>
                <td style="width: 344px;"><span style="text-decoration: underline;font-size:20px"><strong>FACTURE N&deg; {{$facture->numero}}</strong></span></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 59px; width: 311px;">
        <tbody>
            <tr>
                <td style="width: 158px;"><span style="text-decoration: underline;"><strong>TRANSACTION</strong></span></td>
                <td style="width: 143px;"><span style="text-decoration: underline;"><strong>VENTE</strong></span></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 26px; width: 50%;">
        <tbody>
            <tr>
                <td style="width: 423px;">En l'&eacute;tude de Scp&nbsp; {{$compromis->scp_notaire}}</td>
                <td style="width: 260px;">Pr&eacute;vue pour le : {{ Carbon\Carbon::parse($compromis->date_vente)->format('d/m/Y')}}</td>
            </tr>
        </tbody>
    </table>
    <table style="height: 37px; width: 50%;">
        <tbody>
            <tr>
                <td style="width: 423px;"><span style="text-decoration: underline;"><strong>R&eacute;f.</strong></span><strong>:&nbsp;</strong>&nbsp; Mandat N&deg;&nbsp; {{$compromis->numero_mandat}}&nbsp; du : {{ Carbon\Carbon::parse($compromis->date_mandat)->format('d/m/Y')}}</td>
                <td style="width: 260px;">Affaire suivie par : {{$mandataire->nom}} {{$mandataire->prenom}}</td>
            </tr>
        </tbody>
    </table>
    
    <table style="height: 66px; width: 50%">
        <tbody>
            <tr>
                <td style="width: 48px;">&nbsp;</td>
                <td style="width: 428px;"><span style="text-decoration: underline;"><strong>Vendeur: </span>&nbsp; {{$compromis->civilite_vendeur}}@if($compromis->civilite_vendeur =="M." || $compromis->civilite_vendeur =="Mme") {{$compromis->nom_vendeur}} {{$compromis->prenom_vendeur}} @else  {{$compromis->raison_sociale_vendeur}} @endif</strong></td>
                <td style="width: 391px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 48px;">&nbsp;</td>
                <td style="width: 228px;"><span style="text-decoration: underline;"><strong>Acquereur:</span>&nbsp; {{$compromis->civilite_acquereur}} @if($compromis->civilite_acquereur =="M." || $compromis->civilite_acquereur =="Mme")  {{$compromis->nom_acquereur}} {{$compromis->prenom_acquereur}} @else  {{$compromis->raison_sociale_acquereur}} @endif</strong></td>
                <td style="width: 391px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <table style="height: 63px; width: 50%;">
        <tbody>
            <tr>
                <td style="width: 48px;">&nbsp;</td>
                <td style="width: 428px; "><span style="text-decoration: underline;"><strong>Description et adresse du bien :</strong></span></td>
                <td style="width: 391px;"></td>
    
            </tr>
            <tr style="">
                <td style="width: 48px;">&nbsp;</td>
                <td style="width: 428px; ">{{substr($compromis->description_bien, 0,200)}}... &agrave; {{$compromis->ville_bien}}</td>
                <td style="width: 391px;"></td>
    
            </tr>
        </tbody>
    </table>
    <br>
    <table style="height: 47px; width: 672px;">
        <tbody>
            <tr>
                <td style="width: 400px;">&nbsp;</td>
                <td style="width: 153px;">TOTAL H.T :</td>
                <td style="width: 231px;">{{number_format($compromis->frais_agence - $compromis->frais_agence*0.2,2,'.',' ')}} &euro;</td>
            </tr>
            <tr>
                <td style="width: 400px;">&nbsp;</td>
                <td style="width: 153px;">T.V.A 20% :</td>
                <td style="width: 231px;">{{number_format($compromis->frais_agence * 0.2,2,'.',' ')}} &euro;</td>
            </tr>
            <tr>
                <td style="width: 400px;">&nbsp;</td>
                <td style="width: 153px;">TOTAL T.T.C:</td>
                <td style="width: 231px;">{{number_format($compromis->frais_agence,2,'.',' ')}} &euro;</td>
            </tr>
        </tbody>
    </table>
    <br>

    <table style="height: 42px; width: 50%;">
        <tbody>
            <tr style="height: 25px;">
                <td style="width: 349px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
                <td style="width: 117px; height: 25px;">{{number_format($compromis->frais_agence,2,'.',' ')}} &euro; TTC</td>
                <td style="width: 177px; height: 25px;"><span style="color: #ff0000; font-size:20px">&nbsp;R&eacute;f &agrave; rappeler: {{$facture->numero}}</span></td>
            </tr>
        </tbody>
    
    </table>
    <br>
    
    <table style="height: 40px; width: 50%;">
        <tbody>
            <tr>
                <td style="width: 196px;">
                    <div>
                        <div><span style="text-decoration: underline;"><strong>Conditions de paiement:</strong></span></div>
                    </div>
                </td>
                <td style="width: 488px;">
                    <div>
                        <div>Au plus tard le jour de la signature de l'acte athentique, par virement &agrave; la SARL&nbsp;V4F, en rappelant au moins sur l'objet du virement les r&eacute;f&eacute;rences de la facture.</div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-striped table-bordered table-hover" style="width: 100%;" border="1" cellspacing="0">
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
    <br>

    <div style="text-align: center; font-size: 11px; margin-right: 10%; margin-left: 10%; margin-top: 20px;">
        <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE Carte professionnelle N°1312T14 TVA in FR 67 800738478 - SIRET: 800 738 478 00018 - RCS NIMES 800 738 478
        </p>
    </div>