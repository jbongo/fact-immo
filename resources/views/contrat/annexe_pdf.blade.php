<style>

#footer {
  position: fixed;
  left: 0;
	right: 0;
	color: rgb(12, 2, 2);
	font-size: 0.9em;
}
@page { margin: 60px 50px; }
#footer {
  bottom: 0;
  /* border-top: 0.1pt solid rgb(19, 5, 5); */
}
.page-number:before {
  content: counter(page) "/ 6"  ;
}
body {
font-size: 14px;
font-family: 'Times New Roman', Times, serif
}
</style>

<div id="footer">
    <div class="page-number"></div>
</div>
{{-- {{dd($contrat)}} --}}

<br>
<hr>
{{-- {{$parametre}} --}}

<h3><strong>ANNEXE 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bar&egrave;me du commissionnement direct</strong></h3>
<hr /><hr />
<p>La commission du MANDATAIRE est calcul&eacute;e en pourcentage du montant des honoraires d&rsquo;agence H.T. g&eacute;n&eacute;r&eacute;s par le MANDATAIRE. Ce pourcentage de base est d&eacute;fini selon le choix effectu&eacute; ci-dessous (STARTER ou EXPERT).</p>
<p><strong><u>A &ndash; Pourcentage de base choisi</u></strong></p>
<p>D&eacute;marrage en tant que&nbsp;:</p>
<p><strong>&nbsp;&nbsp;   <input type="checkbox" name="" id=""> &nbsp; STARTER&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$contrat->pourcentage_depart_starter}} % &nbsp; (des honoraires d&rsquo;agence H.T.)</strong></p>
<p style="text-align: right;"><strong><u>conditions et tarifs en annexe 3</u></strong></p>
<p><strong><u>ou</u></strong> d&eacute;marrage <u>directement</u> en tant que&nbsp;:</p>
<p><strong>&nbsp;&nbsp; <input type="checkbox" name="" id=""> &nbsp; EXPERT&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </strong><strong>{{$contrat->pourcentage_depart_expert}}  %&nbsp;&nbsp; (des honoraires d&rsquo;agence H.T.)</strong></p>
<p style="text-align: right;"><strong><u>conditions et tarifs en annexe 3</u></strong></p>
<p>Condition pour le passage &agrave; {{$contrat->pourcentage_depart_expert}} % : r&eacute;aliser {{$contrat->nb_vente_passage_expert}} vente(s).</p>


<p><strong><u>B - Progression du commissionnement</u></strong></p>

<p>Le pourcentage de base en vigueur sera augment&eacute; en fonction des r&eacute;sultats du MANDATAIRE selon les paliers suivants. Ce calcul est fait &agrave; date anniversaire (date de votre début d'activité)&nbsp; :</p>


@php 

    $pourcentage_plafonne = $contrat->pourcentage_depart_expert;

@endphp 

@foreach ($palier_expert as $key => $palier )
    
<ul>
    <li>De &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$palier[2]}} &euro; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &agrave; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if((sizeof($palier) - 1 )== $key ) PLUS de commissions annuelles HT @else {{$palier[3]}} &euro; HT de commissions annuelles @endif*</li>
</ul>
    <p>&nbsp;(De {{lettre_en_nombre($palier[2])}} &euro; hors taxes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &agrave; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if((sizeof($palier) - 1 )== $key ) PLUS @else {{lettre_en_nombre($palier[3])}} &euro; hors taxes @endif ) </p>
    @if($palier[1] > 1)
    <p><strong>Pourcentage en vigueur + {{$palier[1]}} % </strong>&nbsp; &nbsp;</p>
    @endif
    
    @php
        $pourcentage_plafonne += $palier[1];
    @endphp 
    
@endforeach




<p><strong>La r&eacute;mun&eacute;ration directe est plafonn&eacute;e &agrave; {{$pourcentage_plafonne}} % quel que soit le pourcentage de d&eacute;part.</strong></p>
<p>Fait en deux exemplaires&nbsp;&nbsp;&nbsp; &agrave;&nbsp;: {{$parametre->ville}} &nbsp;&nbsp;&nbsp;&nbsp;le&nbsp;: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.................</p>



<table style="height: 124px;" width="100%" border="0" cellpadding="10" >
  <tbody>
  <tr>
  <td style="width: 40%;">{{$parametre->gerant}}  </td>
  <td style="width: 60%;">{{$contrat->user->nom}} {{$contrat->user->prenom}}  </td>
  </tr>
  <tr>
  <td style="width: 40%;">Le MANDANT:   </td>
  <td style="width: 60%;">Le MANDATAIRE: </td>
  </tr>
  </tbody>
  </table>


<div style="page-break-after: always;" ></div>




<h3><strong>ANNEXE 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bar&egrave;me du commissionnement indirect (parrainage)</strong></h3>
<hr /><hr />
<p>&nbsp;</p>
<p><strong><u>R&eacute;mun&eacute;ration associ&eacute;e aux agents (filleuls) pr&eacute;sent&eacute;s au r&eacute;seau</u></strong></p>
<p>La r&eacute;mun&eacute;ration indirecte pour parrainage se base sur l&rsquo;existence de &laquo;&nbsp;cycles de recrutement&nbsp;&raquo; de deux ans. La date de d&eacute;but du 1er cycle de recrutement est celle de l&rsquo;entr&eacute;e du tout premier filleul. Comptent dans ce cycle tous les filleuls entr&eacute;s dans le r&eacute;seau dans les deux ans (24 mois) qui suivent cette date.</p>
<p>&Agrave; l&rsquo;expiration du 1er cycle, un 2&egrave; cycle peut commencer &agrave; la date d&rsquo;entr&eacute;e du prochain filleul. Ce 2&egrave; cycle durera &eacute;galement deux ans &agrave; compter de cette nouvelle date. Et ainsi de suite pour les cycles suivants.</p>
<p>La r&eacute;mun&eacute;ration indirecte pour parrainage se fera pendant trois ans (36 mois) &agrave; compter de l&rsquo;entr&eacute;e du filleul concern&eacute;.</p>
<p>La r&eacute;mun&eacute;ration du parrain se fait comme suit&nbsp;(la date de d&eacute;part pour l&rsquo;ann&eacute;e d&rsquo;exercice du filleul est la date de son entr&eacute;e dans le r&eacute;seau)&nbsp;:</p>
<p>A partir de la 2<sup>ème</sup> année, le parrain devra avoir réalisé un chiffre d'affaires de 30 000 € HT sur les 12 derniers mois afin de pouvoir percevoir les commissions indirectes.</p>
<p>&nbsp;</p>
<p><u>1&egrave;re ann&eacute;e d&rsquo;exercice du filleul&nbsp;: </u></p>
<p>Le parrain recevra 5 % du chiffre d&rsquo;affaires personnel du filleul d&egrave;s le 1er centime (pas de seuil de chiffre d&rsquo;affaires du filleul), en revanche le chiffre d&rsquo;affaires du filleul pour ce calcul est plafonn&eacute; &agrave; 30.000 &euro; HT, soit un maximum de 1.500 &euro; HT de commission indirecte pour l&rsquo;ann&eacute;e d&rsquo;exercice du filleul concern&eacute;. Cette r&egrave;gle s&rsquo;applique &agrave; tous les filleuls quel que soit leur rang.</p>
<p>Ce calcul du plafond des 30 000 &euro; HT est calcul&eacute; sur le chiffre d'affaires des 12 mois pr&eacute;c&eacute;dents du filleul.</p>


<p><u>2&egrave; ann&eacute;e d&rsquo;exercice du filleul&nbsp;: </u></p>
<p>- le filleul concern&eacute; doit avoir un chiffre d&rsquo;affaires annuel sup&eacute;rieur ou &eacute;gal &agrave; 30.000 &euro; HT (seuil)&nbsp;;</p>
<p>- le parrain recevra un pourcentage sur 30.000 &euro; (plafond) comme suit&nbsp;:</p>
<ul>
<li>sur le 1er filleul (du cycle)&nbsp;: 3 % (soit 900 &euro;)</li>
<li>sur le 2&egrave; filleul (du cycle)&nbsp;: 4 % (soit 1.200 &euro;)</li>
<li>sur le 3&egrave; filleul (du cycle)&nbsp;: 5 % (soit 1.500 &euro;)</li>
<li>sur le 4&egrave; filleul et suiv. (du cycle)&nbsp;: 5 % (soit 1.500 &euro;)</li>
</ul>

<p><u>3&egrave; ann&eacute;e d&rsquo;exercice du filleul&nbsp;</u>(derni&egrave;re ann&eacute;e donnant droit &agrave; commission indirecte) :</p>
<p>- le filleul concern&eacute; doit avoir un chiffre d&rsquo;affaires annuel sup&eacute;rieur ou &eacute;gal &agrave; 30.000 &euro; (seuil)&nbsp;;</p>
<p>- le parrain recevra un pourcentage sur 30.000 &euro; (plafond) comme suit&nbsp;:</p>
<ul>
<li>sur le 1er filleul (du cycle)&nbsp;: 1 % (soit 300 &euro;)</li>
<li>sur le 2&egrave; filleul (du cycle)&nbsp;: 3 % (soit 900 &euro;)</li>
<li>sur le 3&egrave; filleul (du cycle)&nbsp;: 4 % (soit 1.200 &euro;)</li>
<li>sur le 4&egrave; filleul (du cycle) et suiv.&nbsp;: 5 % (soit 1.500 &euro;)</li>
</ul>
<p>&nbsp;</p>
<p style="text-align: left;">paraphe MANDANT&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; paraphe MANDATAIRE&nbsp;:</p>

<div style="page-break-after: always;" ></div>
<p><em>ANNEXE 2 SUITE</em></p>
<p>&nbsp;</p>
<p><strong><u>Liste et suivi des agents pr&eacute;sent&eacute;s au r&eacute;seau</u></strong></p>
<p>&nbsp;</p>
<p>Le MANDATAIRE a pr&eacute;sent&eacute; au r&eacute;seau&nbsp;&agrave; ce jour&nbsp;:</p>
<p style="text-align: left;">&nbsp;</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:</p>
<p style="text-align: left;">NOM&nbsp;:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;nom&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le&nbsp;:</p>
<p>&nbsp;</p>
<p>Fait en deux exemplaires&nbsp;&nbsp;&nbsp; &agrave;&nbsp;: BAGNOLS SUR CEZE &nbsp;&nbsp;&nbsp;&nbsp;le&nbsp;: ......................................</p>


<table style="height: 124px;" width="100%" border="0" cellpadding="10" >
  <tbody>
  <tr>
  <td style="width: 40%;">{{$parametre->gerant}}  </td>
  <td style="width: 60%;">{{$contrat->user->nom}} {{$contrat->user->prenom}}  </td>
  </tr>
  <tr>
  <td style="width: 40%;">Le MANDANT:   </td>
  <td style="width: 60%;">Le MANDATAIRE: </td>
  </tr>
  </tbody>
  </table>

<p>&nbsp;</p>




<div style="page-break-after: always;" ></div>

<h3><strong>ANNEXE 3</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>Engagement &agrave; payer</h3>
<hr /><hr />
<p>&nbsp;</p>
<p><strong><u>FORFAIT D&rsquo;ENTREE</u></strong><strong> :</strong>&nbsp;&nbsp;&nbsp; factur&eacute; &agrave; la signature du contrat d&rsquo;agent: {{$contrat->forfait_administratif}} € HT + {{$contrat->forfait_carte_pro}} € pour l'obtention de l'attestation professionnelle</p>

<p>Ouverture des comptes administratifs internes et externes (attestation de Mandataire immobilier etc.).</p>
<p>Remboursement&nbsp;: {{$contrat->forfait_administratif}} &euro; HT &nbsp;sur la premi&egrave;re vente qui devra &ecirc;tre effectu&eacute;e dans les 8 mois suivant le d&eacute;but d&rsquo;activit&eacute;.</p>
<p>&nbsp;</p>
<p><strong><u>ET</u></strong></p>
<p>&nbsp;</p>
<p><strong><u>FORFAIT MENSUEL</u></strong>&nbsp;(STARTER <strong><em><u>ou</u></em></strong> EXPERT)&nbsp;:</p>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong><u>FORFAIT MENSUEL &laquo;&nbsp;STARTER&nbsp;&raquo;</u></strong> :</li>
</ul>
<p>Ce forfait comprend&nbsp;: suivi/conseil + formations + outils informatiques + outils publicitaires correspondant au pack 10.</p>
<p>Le prix mensuel du forfait STARTER&nbsp;est de&nbsp;:</p>
<ul>
<li>Du 1<sup>er</sup> au 2&egrave; mois inclus*&nbsp;: gratuit</li>
<li>Du 3&egrave; au 6&egrave; mois inclus*&nbsp;: {{$contrat->forfait_pack_info}} &euro; H.T. en pr&eacute;l&egrave;vement automatique jusqu'&agrave; {{$contrat->nb_vente_passage_expert}} vente(s).</li>
</ul>
<p>Le forfait STARTER est valable au maximum les 6 premiers mois*.</p>
<p>Au 7&egrave; mois* le MANDATAIRE passe automatiquement au forfait EXPERT (pack 10 sauf autre choix).</p>
<p><em>*&nbsp;: mois suivant la date de d&eacute;but d&rsquo;activit&eacute; inscrite dans le contrat.</em></p>
<p>&nbsp;</p>
<ul>
<li><strong><u>FORFAIT MENSUEL &laquo;&nbsp;EXPERT&nbsp;&raquo;</u></strong>: </strong></li>
</ul>
<p>Ce forfait comprend&nbsp;: suivi/conseil + formations + outils informatiques + outils publicitaires correspondant au pack choisi par le MANDATAIRE.</p>
<p>Prix mensuel du forfait EXPERT&nbsp;(&agrave; compter du d&eacute;marrage d&rsquo;activit&eacute;)&nbsp;:</p>
<p>Tarifs &agrave; ce jour&nbsp;:</p>

@foreach($packs as $pack)
  @if($pack->type == "reseau")
  <p>&nbsp;- {{$pack->nom}}&nbsp;: {{$pack->tarif_ht}} &euro; H.T.,</p>
  @endif
@endforeach
<p>&nbsp;</p>

<p style="text-align: left;">paraphe MANDANT&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; paraphe MANDATAIRE&nbsp;:</p>




<div style="page-break-after: always;" ></div>



<p><em>ANNEXE 3 SUITE</em></p>
<p><strong>&nbsp;</strong></p>
<p><strong>1.| Outils Informatiques </strong></p>
<p>Logiciel de transaction immobili&egrave;re, logiciel de pige, logiciel de registre des mandats.</p>
<p><strong>2. | Outils Publicitaires </strong></p>
<p>Les annonces sont diffus&eacute;es sur les passerelles suivantes (liste qui peut &ecirc;tre amen&eacute;e &agrave; varier en fonction des n&eacute;gociations tarifaires avec nos fournisseurs, des changements impos&eacute;s par ceux-ci, de la performance des sites)&nbsp;:</p>
<p>SE LOGER | LE BON COIN | LOGIC IMMO | BIEN ICI</p>
<p>LES CLES DU MIDI | PARU VENDU | GREEN-ACRES &hellip;..</p>
<p>&nbsp;</p>
<p>Le paiement sera effectu&eacute; par pr&eacute;l&egrave;vement le 5 du mois en cours. En cas de rejet de pr&eacute;l&egrave;vement, de non-r&egrave;glement et/ou d&rsquo;impay&eacute;, un forfait de 20 &euro; H.T. par incident pour frais bancaires et de gestion associ&eacute;s sera factur&eacute; en sus au MANDATAIRE.</p>
<p>Le mandant se r&eacute;serve le droit de suspendre ses prestations en cas de non-paiement du forfait.</p>
<p>Tout mois entam&eacute; est d&ucirc; enti&egrave;rement. Les frais pay&eacute;s par le MANDATAIRE restent acquis &agrave; la soci&eacute;t&eacute; V4F. Dans tous les cas, aucun remboursement ne sera effectu&eacute;, pour aucun motif que ce soit, m&ecirc;me en cas de suspension pr&eacute;vue au paragraphe pr&eacute;c&eacute;dent.</p>
<p>STYL&rsquo;IMMO s&rsquo;&eacute;vertue &agrave; obtenir des tarifs pr&eacute;f&eacute;rentiels aupr&egrave;s de ses partenaires&nbsp;; n&eacute;anmoins, les tarifs des packs peuvent &ecirc;tre amen&eacute;s &agrave; &ecirc;tre modifi&eacute;s &agrave; tout moment en fonction des n&eacute;gociations avec nos fournisseurs et des changements impos&eacute;s par ceux-ci.</p>
<p>&nbsp;</p>
<p>Accord particulier&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>........................................................................................................................................................................................ <br> </p>
<p>........................................................................................................................................................................................ <br> </p>
<p>........................................................................................................................................................................................ <br> </p>
<p>........................................................................................................................................................................................ <br> </p>
<p>&nbsp;</p>
<p>Fait en deux exemplaires&nbsp;&nbsp;&nbsp; &agrave;&nbsp;: BAGNOLS SUR CEZE &nbsp;&nbsp;&nbsp;&nbsp;le : ..........................</p>



<table style="height: 124px;" width="100%" border="0" cellpadding="10" >
  <tbody>
  <tr>
  <td style="width: 40%;">{{$parametre->gerant}}  </td>
  <td style="width: 60%;">{{$contrat->user->nom}} {{$contrat->user->prenom}}  </td>
  </tr>
  <tr>
  <td style="width: 40%;">Le MANDANT:   </td>
  <td style="width: 60%;">Le MANDATAIRE: </td>
  </tr>
  </tbody>
  </table>
<p>&nbsp;</p>



<div style="page-break-after: always;" ></div>





<h3><strong>ANNEXE 4 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bar&egrave;me d&rsquo;honoraires</strong></h3>
<hr /><hr />
<p>&nbsp;</p>
<table style="height: 190px; width: 692px;" border="1" cellspacing="0">
<tbody>
<tr>
<td style="width: 260px;" colspan="2">
<p style="text-align: center;">Prix de vente</p>
</td>
<td style="width: 260px;" rowspan="2">
<p style="text-align: center;">Honoraires</p>
<p style="text-align: center;">&nbsp;</p>
</td>
</tr>
<tr>
<td style="width: 130px;">De:</td>
<td style="width: 130px;">A:</td>
</tr>
<tr>
<td style="width: 130px;">1&euro;</td>
<td style="width: 130px;">50&nbsp;000 &euro;&nbsp;&nbsp;</td>
<td style="width: 246px; text-align: center;">Forfait Minimum de 4 000 &euro; TTC</td>
</tr>
<tr>
<td style="width: 130px;">50&nbsp;001 &euro;</td>
<td style="width: 130px;">100 000 &euro;</td>
<td style="width: 246px; text-align: center;">Forfait Maximum de 8 000 &euro; TTC</td>
</tr>
<tr>
<td style="width: 130px;">100 001 &euro;</td>
<td style="width: 130px;">300 000 &euro;</td>
<td style="width: 246px; text-align: center;">6%</td>
</tr>
<tr>
<td style="width: 130px;">300 001 &euro;</td>
<td style="width: 130px;">600 000 &euro;</td>
<td style="width: 246px; text-align: center;">5.50%</td>
</tr>
<tr>
<td style="width: 130px;">600 001 &euro;</td>
<td style="width: 130px;">900 000 &euro;</td>
<td style="width: 246px; text-align: center;">5,25%</td>
</tr>
<tr>
<td style="width: 130px;">900 001 &euro;</td>
<td style="width: 130px;">Et plus</td>
<td style="width: 246px; text-align: center;">5%</td>
</tr>
</tbody>
</table>


<p>Le MANDATAIRE s'engage &agrave; ne pas d&eacute;passer ou modifier ce bar&egrave;me &agrave; la hausse mais pourra cependant accorder des remises &agrave; la client&egrave;le sur le montant des commissions pr&eacute;vues au dit bar&egrave;me. Ce bar&egrave;me d&rsquo;honoraires s&rsquo;applique sur tous types de mandat (recherche&hellip;, vente&hellip;) li&eacute;s &agrave; une transaction immobili&egrave;re.</p>
<p>&nbsp;</p>
<p>Fait en deux exemplaires&nbsp;&nbsp;&nbsp; &agrave;&nbsp;&nbsp;&nbsp; BAGNOLS SUR CEZE&nbsp;&nbsp; &nbsp;le&nbsp; :&nbsp; &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</p>

<table style="height: 124px;" width="100%" border="0" cellpadding="10" >
  <tbody>
  <tr>
  <td style="width: 40%;">{{$parametre->gerant}}  </td>
  <td style="width: 60%;">{{$contrat->user->nom}} {{$contrat->user->prenom}}  </td>
  </tr>
  <tr>
  <td style="width: 40%;">Le MANDANT:   </td>
  <td style="width: 60%;">Le MANDATAIRE: </td>
  </tr>
  </tbody>
  </table>


<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIGNATURE POUR L&rsquo;ENSEMBLE DES ANNEXES 1 &agrave; 4 </strong></p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</p>

<p>La direction se r&eacute;serve le droit de modifier &agrave; tout moment et sans pr&eacute;avis les annexes 1 &agrave; 4. Toute modification ainsi faite est r&eacute;put&eacute;e accept&eacute;e par le MANDATAIRE d&egrave;s sa notification par mail. Exception&nbsp;: une modification du pourcentage de r&eacute;mun&eacute;ration directe ainsi que mentionn&eacute;e &agrave; l&rsquo;article 3.1. du contrat.</p>

<p>Fait en deux exemplaires&nbsp;&nbsp;&nbsp; &agrave;&nbsp;&nbsp;&nbsp; BAGNOLS SUR CEZE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;le :&nbsp;...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.....&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&nbsp;&nbsp;</p>



<table style="height: 124px;" width="100%" border="0" cellpadding="10" >
  <tbody>
  <tr>
  <td style="width: 40%;">{{$parametre->gerant}}  </td>
  <td style="width: 60%;">{{$contrat->user->nom}} {{$contrat->user->prenom}}  </td>
  </tr>
  <tr>
  <td style="width: 40%;">Le MANDANT   </td>
  <td style="width: 60%;">Le MANDATAIRE </td>
  </tr>
  <tr>
  <td style="width: 40%;">Mention manuscrite:  </td>
  <td style="width: 60%;">Mention manuscrite:  </td>
  </tr>
  <tr>
  <td style="width: 40%;">&laquo;&nbsp;Lu et approuv&eacute;, Bon pour mandat &nbsp;&raquo;  </td>
  <td style="width: 60%;">&laquo;&nbsp;Lu et approuv&eacute;, Bon pour acceptation de mandat&nbsp;&raquo;  </td>
  </tr>
  <tr>
  <td style="width: 40%;">Signature  </td>
  <td style="width: 60%;">Signature  </td>
  </tr>
  </tbody>
  </table>



<p>&nbsp;</p>