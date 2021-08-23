<!doctype html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Contrat</title>
</head>
<body>

<style>


#footer {
  position: fixed;
  left: 0;
	/* right: 0; */
	color: rgb(12, 2, 2);
	font-size: 0.9em;
}

#footer {
  bottom: 0;
  border-top: 0.1pt solid rgb(19, 5, 5);
}
.page-number:before {
  content: counter(page) "/ 11";
}

body {
font-size: 14px;
font-family: 'Times New Roman', Times, serif
}


@page { margin: 60px 50px; }
.footer, .paraphe {
    position: fixed;
    bottom: 0;
    left: 0px; right: 0px;  height: 15px; 
    align-content: center;
    font-size: 14px;

}
      


</style>


<div class="footer">
    <div class="page-number"></div>
</div>

<div class="paraphe" style="text-align: left;  margin-right: 1%; margin-left: 5%; margin-top: 20px;" class="paraphes">PARAPHES  &nbsp; Mandataire: <span style="margin-left: 25%">Mandant:</span> </div>

  
<h1 style="text-align: center;">CONTRAT D&rsquo;AGENT COMMERCIAL</h1>
<h2 style="text-align: center;"><strong>&nbsp;N&eacute;gociateur en immobilier</strong></h2>
<h2 style="text-align: center;"><strong>Sans bureau ni r&eacute;ception de client&egrave;le</strong></h2>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p style="text-align: center;">Ce contrat est conforme&nbsp;:</p>
<ul>
<li>&agrave; l'article 4 de la loi n&deg; 70-9 du 2 janvier 1970</li>
<li>conforme &agrave; la loi du 25 juin 1991 relatif aux agents commerciaux</li>
<li>&agrave; l'article 9 du D&eacute;cret n<sup>9 </sup>72-678 du 20 Juillet 1972</li>
<li>&agrave; la loi "E.N.L." n&deg; 2006-872 du 13 Juillet 2006</li>
</ul>
<p><u>Entre les soussign&eacute;s </u>:</p>
<p><strong>La soci&eacute;t&eacute; {{$parametre->raison_sociale}}&nbsp;, </strong>SARL au capital de {{$parametre->capital}} &euro; inscrite au R.C&nbsp;.S. de N&icirc;mes, sous le num&eacute;ro {{$parametre->numero_rcs}}, titulaire de la carte professionnelle &laquo;&nbsp;Agent Immobilier&nbsp;&raquo; n&deg; {{$parametre->num_carte_pro}} (transactions sur immeubles et fonds de commerce), d&eacute;livr&eacute;e le 12/06/2014 par {{$parametre->carte_pro_delivre_par}} (organisme de garantie&nbsp;: {{$parametre->adresse_organisme_de_garantie}}), dont le si&egrave;ge est sis {{$parametre->adresse}}, {{$parametre->code_postal}} {{$parametre->ville}}, l&eacute;galement repr&eacute;sent&eacute;e par {{$parametre->gerant}}, g&eacute;rante.</p>
<p>Ci-apr&egrave;s d&eacute;nomm&eacute; &laquo;&nbsp;LE MANDANT&nbsp;&raquo;</p>
<p style="text-align: right;">D&rsquo;une part</p>
<p>Et&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pr&eacute;sent&eacute;(e) au R&eacute;seau par&nbsp;:</p>
<p>NOM&nbsp;:&nbsp;  {{$contrat->user->nom}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; Pr&eacute;nom&nbsp;: &nbsp;  {{$contrat->user->prenom}}&nbsp;&nbsp;</p>
<p>Demeurant au&nbsp;: &nbsp;  {{$contrat->user->adresse}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>
<p>Code postal et ville&nbsp;: &nbsp;  {{$contrat->user->code_postal}} - {{$contrat->user->ville}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>
<p>N&eacute;(e)&nbsp; : &nbsp;  @if($contrat->user->prospect != null) {{$contrat->user->prospect->date_naissance->format("d-m-Y")}} @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &agrave;&nbsp;: &nbsp;  @if($contrat->user->prospect != null) {{$contrat->user->prospect->lieu_naissance}} @endif &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>De nationalit&eacute;&nbsp;:&nbsp;  @if($contrat->user->prospect != null) {{$contrat->user->prospect->nationnalite}} @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>
<p>Situation familiale&nbsp;:&nbsp;  @if($contrat->user->prospect != null) {{$contrat->user->prospect->situation_familliale}} @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>
<p>Ci-apr&egrave;s d&eacute;nomm&eacute;(e) &laquo;&nbsp;LE MANDATAIRE&nbsp;&raquo;</p>
<p>D&rsquo;autre part</p>
<p>&nbsp;</p>

{{-- PAGE 1 --}}

<p style="text-align: center;page-break-before:always"><strong><u>EXPOSE PREALABLE</u></strong></p>
<p>Monsieur VASILE Jean-Pierre exploite depuis plusieurs ann&eacute;es l&rsquo;activit&eacute; d&rsquo;agent immobilier, g&eacute;rant d&rsquo;immeubles, marchand de biens, publicit&eacute; et marketing, notamment sous la marque commerciale &laquo;&nbsp;STYL&rsquo;IMMO&nbsp;&raquo;, dont il est propri&eacute;taire.</p>
<p>Cette marque est la propri&eacute;t&eacute; exclusive de Monsieur Jean-Pierre VASILE.</p>
<p>Elle est exploit&eacute;e par la soci&eacute;t&eacute; {{$parametre->raison_sociale}} et couvre globalement les produits et services suivants&nbsp;:</p>
<p>- Publicit&eacute;, gestion des affaires commerciales, administration commerciale, travaux de bureau, diffusion de mat&eacute;riel publicitaire (tract, contrat->userus, imprim&eacute;s, &eacute;chantillons), conseil en organisation et direction des affaires, comptabilit&eacute;&nbsp;;</p>
<p>- Affaires financi&egrave;res, affaires immobili&egrave;res, estimations immobili&egrave;res, g&eacute;rance de biens immobiliers, constitution ou investissement de capitaux, estimations financi&egrave;res (immobilier), transactions immobili&egrave;res, administration de biens.</p>
<p>- Services juridiques&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>Elle est d&ucirc;ment prot&eacute;g&eacute;e et enregistr&eacute;e en France aupr&egrave;s de l&rsquo;INPI selon certificat d&rsquo;enregistrement en date du 19 juin 2017, N&deg; 17 4&nbsp;369 620.</p>
<p>Le mandataire se d&eacute;clare s&eacute;duit par le concept de &laquo;&nbsp;STYL&rsquo;IMMO&nbsp;&raquo;. C&rsquo;est la raison pour laquelle les parties se sont rapproch&eacute;es et ont convenu de conclure un contrat de collaboration devant gouverner leurs relations contractuelles.</p>
<p>Il reconna&icirc;t avoir eu le temps n&eacute;cessaire pour r&eacute;fl&eacute;chir et se faire conseiller avant la signature du pr&eacute;sent contrat de collaboration.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;d&eacute;clare &ecirc;tre immatricul&eacute;(e) au Registre sp&eacute;cial des agents commerciaux tenu au greffe du tribunal de commerce de &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;. sous le num&eacute;ro &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;*.</p>
<p>Si l&rsquo;inscription est en cours, le contrat prendra r&eacute;ellement effet &agrave; la r&eacute;ception des documents d&rsquo;immatriculation officiels, cette date pr&eacute;vaudra sur les &eacute;ventuelles dates de d&eacute;marrage not&eacute;es en derni&egrave;re page.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp; * si ce champ n&rsquo;est pas renseign&eacute;, cela signifie en cours d&rsquo;enregistrement.</p>
<p><u>Ceci expos&eacute;, il a &eacute;t&eacute; convenu et arr&ecirc;t&eacute; ce qui suit&nbsp;:</u></p>
<p>&nbsp;</p>
<p><strong><u>Article 1<sup>er</sup> : MANDAT D'HABILITATION</u></strong></p>
<p>&Agrave; dater de la signature du pr&eacute;sent contrat qui est conclu dans le cadre des dispositions de la loi N&deg;70-9 du 2 janvier 1970 (dite loi "Hoguet") et de son d&eacute;cret d&rsquo;application, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;s'engage &agrave; repr&eacute;senter commercialement la soci&eacute;t&eacute; {{$parametre->raison_sociale}} pour la recherche de vendeurs et d'acqu&eacute;reurs de biens immobiliers d'habitation ou commerciaux.</p>
<p>Le MANDATAIRE s'efforcera d'obtenir de ses clients les mandats n&eacute;cessaires au bon d&eacute;roulement de la mission du MANDANT.</p>
<p>LE MANDATAIRE exercera cette activit&eacute; sans aucun lien de subordination vis-&agrave;-vis du MANDANT et dans le respect du statut de travailleur ind&eacute;pendant, agent commercial.</p>
<p>LE MANDATAIRE ne saurait en aucun cas relever des disposions des articles L7311-1 et suivants du Code du Travail, ni &ecirc;tre soumis aux diverses obligations r&eacute;sultant de ces textes, n'&eacute;tant aucunement subordonn&eacute; au MANDANT ni salari&eacute; par ce dernier.</p>
<p>LE MANDATAIRE accomplira les activit&eacute;s n&eacute;es de l'exercice du pr&eacute;sent mandat sous la marque "STYL&rsquo;IMMO" ou sous toute autre marque commerciale si le MANDANT devait en changer.</p>
<p>&nbsp;</p>

{{-- PAGE 2 --}}


<p style="text-align: center;page-break-before:always"><strong><u>Article 2 : CONDITIONS D'EXERCICE DU MANDAT</u></strong></p>

<p>LE MANDATAIRE devra &ecirc;tre titulaire et porteur d'une attestation d&eacute;livr&eacute;e par la CCI, conform&eacute;ment &agrave; l'article 4 de la loi N&deg;70-9 du 2 Janvier 1970 (loi "Hoguet") et &agrave; l'article 9 du d&eacute;cret n&deg;72-678 du 20 Juillet 1972 modifi&eacute; par d&eacute;cret n&deg;2005-1315 du 21 octobre 2005.</p>
<p>Avant de commencer son activit&eacute; et sa contrat->userion, LE MANDATAIRE devra &ecirc;tre titulaire et porteur de cette attestation que le MANDANT s'oblige &agrave; lui faire d&eacute;livrer.</p>
<p>En sa qualit&eacute; de travailleur ind&eacute;pendant l&eacute;galement habilit&eacute;, LE MANDATAIRE exerce ses activit&eacute;s en dehors de tout lien hi&eacute;rarchique vis-&agrave;-vis de son MANDANT, jouit de la plus grande ind&eacute;pendance et n'est astreint &agrave; aucun horaire de travail ou permanence quelconque.</p>
<p>&Agrave; ce titre, il contrat->usere &agrave; sa convenance, organise et effectue ses tourn&eacute;es comme bon lui semble et s'absente &agrave; son gr&eacute;. Il ne lui est donn&eacute; aucun ordre. Il n'est soumis &agrave; aucun rapport p&eacute;riodique. Il peut travailler dans toutes r&eacute;gions pour tout autre &eacute;tablissement de la marque et/ou pour son propre compte.</p>
<p>Le MANDATAIRE s'interdit d'accepter la repr&eacute;sentation ou d'&ecirc;tre mandat&eacute;, pour toute autre raison que des actions de N&eacute;gociateur en immobilier, par une entreprise concurrente du MANDANT exer&ccedil;ant l'activit&eacute; d'agent immobilier, de marchand de biens ou de commercialisation de produits immobiliers de d&eacute;fiscalisation.</p>
<p>Toutefois, il pourra collaborer en "Inter cabinets" avec d'autres agences immobili&egrave;res ou professionnels immobiliers de son choix en respectant les proc&eacute;dures l&eacute;gales de d&eacute;l&eacute;gation de mandat.</p>
<p>LE MANDATAIRE pourra donc transmettre &agrave; d'autres agents ou agences immobili&egrave;res une affaire &agrave; vendre.</p>
<p>Dans ce cas, il devra imp&eacute;rativement communiquer au MANDANT la copie de la d&eacute;l&eacute;gation de mandat qu'il accorde &agrave; ce confr&egrave;re.</p>
<p>Conform&eacute;ment aux usages de la profession, le MANDATAIRE qui re&ccedil;oit une d&eacute;l&eacute;gation de mandat de la part d'une autre agence immobili&egrave;re doit imp&eacute;rativement lui assigner un num&eacute;ro d'enregistrement et adresser un exemplaire original de cette d&eacute;l&eacute;gation au si&egrave;ge du MANDANT, accompagn&eacute; de la copie du mandat original donn&eacute; par le client &agrave; ce confr&egrave;re.</p>
<p>En cas d'op&eacute;ration men&eacute;e conjointement avec un autre agent ou une autre agence immobili&egrave;re, la part de commission revenant au MANDATAIRE devra OBLIGATOIREMENT transiter par le compte bancaire de la soci&eacute;t&eacute; {{$parametre->raison_sociale}} (compte n&deg;00020227203 sur la Banque Cr&eacute;dit Mutuel Bagnols sur C&egrave;ze).</p>
<p>Les clauses ci-dessus sont consid&eacute;r&eacute;es comme essentielles pour la validit&eacute; du pr&eacute;sent contrat. En cas de non-respect par LE MANDATAIRE, le MANDANT pourra &agrave; tout moment et sans indemnit&eacute; r&eacute;silier le pr&eacute;sent contrat par lettre recommand&eacute;e avec demande d'avis de r&eacute;ception, sous respect d'un pr&eacute;avis de 15 jours.</p>
<p>LE MANDATAIRE accepte express&eacute;ment le principe de diffusion de ses biens &agrave; vendre aux autres professionnels du groupe ou collaborateurs ind&eacute;pendants du r&eacute;seau, ceci afin de pr&eacute;senter &agrave; la client&egrave;le un fichier de biens plus important et d'augmenter les potentialit&eacute;s de retomb&eacute;es commerciales.</p>
<p>En cas de vente r&eacute;alis&eacute;e dans le cadre d'une op&eacute;ration &laquo;&nbsp;inter-cabinet&nbsp;&raquo;, il y aura partage de la commission entre les agents et/ou collaborateurs concern&eacute;s suivant les usages de la profession et/ou les accords particuliers conclus entre eux avant la signature d&rsquo;une offre ou d&rsquo;un compromis&nbsp;; le MANDATAIRE devra en transmettre les informations au si&egrave;ge du MANDANT.</p>
<p>Le MANDATAIRE est tenu par le secret professionnel.</p>
<p>Il devra tenir une comptabilit&eacute; r&eacute;guli&egrave;re de tous les documents qui lui sont confi&eacute;s.</p>
<p>Il fera sa propre publicit&eacute; en tenant compte des textes l&eacute;gaux en vigueur et s'engage &agrave; toujours employer l'appellation &laquo;&nbsp;STYL&rsquo;IMMO&nbsp;&raquo; sous la forme (charte graphique) agr&eacute;&eacute;e par le MANDANT. Toute communication particuli&egrave;re &agrave; son initiative (m&eacute;dia, support &hellip;) devra &ecirc;tre valid&eacute;e par le si&egrave;ge.</p>



<p style="text-align: center;page-break-before:always"><strong><u>Ind&eacute;pendance juridique du mandataire&nbsp;:</u></strong></p>

<p>Les parties reconnaissent express&eacute;ment que la pr&eacute;sente convention ne s'analyse pas comme un louage de service, mais qu'elle a le caract&egrave;re d'un mandat.</p>
<p>S'il emploie un v&eacute;hicule pour son transport, il appartient au MANDATAIRE de prendre toutes les pr&eacute;cautions d'assurances n&eacute;cessaires car n'ayant aucune part dans ses d&eacute;cisions, le MANDANT ne peut encourir aucune responsabilit&eacute; &agrave; l'&eacute;gard de quiconque ou de tiers transport&eacute;s, ni dans le cas o&ugrave; le MANDATAIRE serait victime d'un accident dans l'exercice de son mandat.</p>
<p>Il devra souscrire une police d'assurance couvrant sa responsabilit&eacute; civile professionnelle, tant &agrave; l'&eacute;gard des tiers que du MANDANT, pour son activit&eacute; de n&eacute;gociateur en immobilier ind&eacute;pendant telle que d&eacute;finie au pr&eacute;sent contrat.</p>
<p>Le MANDATAIRE devra communiquer, &agrave; premi&egrave;re demande du MANDANT, une copie de ladite police et un justificatif du paiement de la derni&egrave;re quittance appel&eacute;e.</p>
<p>Dans l'hypoth&egrave;se o&ugrave; le MANDATAIRE ne justifierait pas disposer des garanties ci-dessus d&eacute;finies dans les 8 jours suivant la demande faite par le MANDANT, le pr&eacute;sent contrat sera r&eacute;sili&eacute; sans pr&eacute;avis, aux torts exclusifs du MANDATAIRE.</p>
<p>D'une fa&ccedil;on g&eacute;n&eacute;rale, le MANDATAIRE supportera tous les frais occasionn&eacute;s par sa contrat->userion et prendra en charge, le cas &eacute;ch&eacute;ant, son propre secr&eacute;tariat.</p>
<p>Il s'engage &agrave; rapporter dans un d&eacute;lai d'un mois maximum la preuve de son affiliation &agrave; l'URSSAF, de son inscription aux diff&eacute;rentes caisses sociales (Allocations Familiales, Retraite Vieillesse, Assurance Maladie), et de son inscription au Registre Sp&eacute;cial des Agents Commerciaux (RSAC) tenu par le Greffe du Tribunal de Commerce dont il d&eacute;pend. Il fera son affaire personnelle de toutes charges fiscales et sociales lui incombant &agrave; ce titre.</p>
<p>Il devra s'acquitter de la T.V.A. sur ses commissions et justifiera sur demande du MANDANT du paiement des taxes obligatoires sauf dans le cas o&ugrave; il opterait pour le r&eacute;gime de la micro entreprise.</p>
<p>En cas de non-respect de ces engagements dans les d&eacute;lais pr&eacute;vus, ladite convention serait automatiquement rompue sans indemnit&eacute; pour le MANDATAIRE, les parties reconnaissant que ces conditions sont un &eacute;l&eacute;ment essentiel de leur accord r&eacute;ciproque.</p>
<p>Le MANDATAIRE s'engage en outre &agrave; ne pas d&eacute;clarer fiscalement au titre des "traitements et salaires" le produit de ses commissions r&eacute;sultant du pr&eacute;sent mandat, &agrave; ne recevoir aucun paiement ni aucune r&eacute;mun&eacute;ration sous quelque forme que ce soit directement de la part de la client&egrave;le.</p>
<p>Il est pr&eacute;cis&eacute; que tous les documents officiels utilis&eacute;s par le MANDATAIRE (papier &agrave; lettres, tampons, etc.) devront porter la mention "agent commercial ind&eacute;pendant" et reproduire obligatoirement le sigle du MANDANT et la r&eacute;f&eacute;rence de la carte professionnelle du MANDANT avec les mentions obligatoires &eacute;dict&eacute;es par l'article 93 du D&eacute;cret du 20 Juillet 1972, modifi&eacute; par d&eacute;cret n&deg;2005-1315 du 21 octobre 2005, dont la lecture lui a &eacute;t&eacute; donn&eacute;e en int&eacute;gralit&eacute;.</p>
<p>Le MANDATAIRE a pris connaissance du bar&egrave;me d'honoraires du MANDANT dont un exemplaire lui est remis ce jour, il s'engage &agrave; ne pas le d&eacute;passer &agrave; la hausse mais pourra cependant accorder des remises &agrave; la client&egrave;le sur le montant des commissions pr&eacute;vues au dit bar&egrave;me.</p>
<p>&nbsp;</p>
<p><strong><u>Article 3 : HONORAIRES DE COLLABORATION &ndash; COMMISSIONS</u></strong></p>
<p><strong><u>Article 3.1 Commissions directes</u></strong></p>
<p>Le MANDATAIRE percevra une commission Toutes Taxes Comprises (sauf dans le cas du r&eacute;gime micro entreprise o&ugrave; la commission sera alors r&eacute;gl&eacute;e Hors Taxe) sur le montant des commissions ou honoraires r&eacute;gl&eacute;s au MANDANT dans le cadre des activit&eacute;s n&eacute;es de l'exercice de son mandat par le MANDATAIRE dans la mesure toutefois o&ugrave; l'affaire en cause aura &eacute;t&eacute; enti&egrave;rement trait&eacute;e par son interm&eacute;diaire.</p>
<p>Le MANDATAIRE fera son affaire personnelle de toute indemnit&eacute; qu'il pourrait &ecirc;tre tenu de verser &agrave; ses apporteurs d'affaires ou tout autre collaborateur. Aucune indemnit&eacute; ne sera due au MANDATAIRE pour les affaires non effectivement r&eacute;alis&eacute;es et n'ayant donn&eacute; lieu &agrave; aucun r&egrave;glement.</p>
<p>La part de commission qui lui revient conform&eacute;ment au bar&egrave;me &eacute;tabli sera r&eacute;gl&eacute;e au MANDATAIRE apr&egrave;s parfait encaissement par le MANDANT du ch&egrave;que ou virement correspondant &agrave; la commission globale de l'agence. Ce ch&egrave;que sera obligatoirement &eacute;tabli &agrave; l'ordre de la soci&eacute;t&eacute; &laquo;&nbsp;{{$parametre->raison_sociale}} &raquo;, titulaire de la carte professionnelle d'agent immobilier.</p>
<p>Le r&egrave;glement au MANDATAIRE se fera dans un d&eacute;lai de 72 heures ouvrables apr&egrave;s encaissement par le MANDANT de la commission globale. Ce d&eacute;lai sera port&eacute; &agrave; 12 jours ouvrables en cas de ch&egrave;que provenant d'un particulier.</p>
<p>Le commissionnement d&ucirc; au MANDATAIRE est calcul&eacute; par tranches cumulatives, sans effet r&eacute;troactif, &agrave; la date anniversaire de d&eacute;but d&rsquo;activit&eacute;, <strong><u>suivant le bar&egrave;me joint en annexe 1.</u></strong> Toute modification du pourcentage de r&eacute;mun&eacute;ration directe (annexes 1 et 3) d&eacute;cid&eacute;e par la direction et notifi&eacute;e par mail au mandataire doit &ecirc;tre approuv&eacute;e par le mandataire. En cas de refus de sa part, ce refus pourra &ecirc;tre consid&eacute;r&eacute; comme une rupture unilat&eacute;rale de contrat de sa part.</p>
<p>Le MANDATAIRE adressera au MANDANT une facture de commission conforme aux sp&eacute;cifications l&eacute;gislatives et comptables faisant ressortir le montant de la T.V.A.</p>
<p>En cas d'affaire trait&eacute;e en collaboration avec d'autres agents ou agences immobili&egrave;res HORS Styl&rsquo;Immo, le partage de commission s'effectuera librement suivant les usages et/ou accords conclus entre eux, et la part de commission revenant au MANDATAIRE sera toujours prise sur la seule participation revenant au MANDANT.</p>
<p>En cas d'affaire trait&eacute;e en collaboration avec d'autres agents du r&eacute;seau Styl&rsquo;Immo, le partage de commission s'effectuera selon la r&egrave;gle suivante&nbsp;:</p>
<p>50 % de la commission mandataire pour le mandataire qui am&egrave;ne le mandat,</p>
<p>50% de la commission mandataire pour le mandataire qui am&egrave;ne l&rsquo;acqu&eacute;reur.</p>
<p>Tout cas particulier ou partage de commission sur une autre base doit faire l&rsquo;objet de l&rsquo;accord PR&Eacute;ALABLE du si&egrave;ge.</p>
<p><strong><u>Article 3.2 Commissions indirectes</u></strong></p>
<p>Le Mandataire percevra un pourcentage du chiffre d&rsquo;affaires d&rsquo;un nouvel agent commercial qu&rsquo;il aura <strong><u>pr&eacute;sent&eacute; </u></strong>au r&eacute;seau STYL&rsquo;IMMO, <strong><u>suivant le bar&egrave;me et les conditions joints en annexe 2.</u></strong> La direction se r&eacute;serve le droit de modifier &agrave; tout moment et sans pr&eacute;avis les r&egrave;gles, montants et conditions du commissionnement indirect. Toute modification ainsi faite est r&eacute;put&eacute;e accept&eacute;e par le mandataire d&egrave;s sa notification par mail.</p>
<p>Toute nouvelle source de commissions fera l&rsquo;objet d&rsquo;un avenant sur les annexes du contrat initial du mandataire.</p>
<p>L&rsquo;ensemble de ces commissions indirectes a pour but de favoriser le d&eacute;veloppement et l&rsquo;unit&eacute; du r&eacute;seau.</p>
<p>Les commissions indirectes et qui ne concernent pas une transaction immobili&egrave;re propre ne sont pas soumises &agrave; un droit de suite.</p>
<p>Les commissions indirectes sont soumises aux conditions suivantes cumul&eacute;es&nbsp;:</p>
<ul>
<li>Parfait encaissement de la commission globale d&rsquo;agence par {{$parametre->raison_sociale}} <strong>ET</strong></li>
<li>Parrain actif et non en statut de sortie <strong>ET</strong></li>
<li>Parrain actif et non en statut d&rsquo;arr&ecirc;t temporair <strong>ET</strong></li>
<li>Filleul actif et non en statut de sortie. <strong>ET</strong></li>
<li>Filleul actif et non en statut d&rsquo;arr&ecirc;t temporaire</li>
</ul>
<p>Par sa d&eacute;mission, le mandataire parrain perd tout droit &agrave; commission indirecte et ce d&egrave;s r&eacute;ception de sa d&eacute;mission. En cas de fin du pr&eacute;sent contrat par une autre proc&eacute;dure il perd tout droit &agrave; commission indirecte d&egrave;s la fin du contrat.</p>
<p>De m&ecirc;me le mandataire parrain perd tout droit &agrave; commission indirecte en cas de d&eacute;mission de son filleul et ce d&egrave;s r&eacute;ception de ladite d&eacute;mission. En cas de rupture du contrat du filleul par une autre proc&eacute;dure, le mandataire parrain perd tout droit &agrave; commission indirecte d&egrave;s la fin du contrat dudit filleul.</p>
<p>&nbsp;</p>
<p><strong><u>Article 4&nbsp;: DUREE ET RESILIATION</u></strong></p>
<p>Le pr&eacute;sent mandat est &eacute;tabli pour une dur&eacute;e ind&eacute;termin&eacute;e.</p>
<p>Il pourra &ecirc;tre d&eacute;nonc&eacute; par l&rsquo;une ou l&rsquo;autre des parties par lettre recommand&eacute;e avec demande d&rsquo;avis de r&eacute;ception en respectant un pr&eacute;avis d&rsquo;un mois pour la premi&egrave;re ann&eacute;e, de deux mois pour la deuxi&egrave;me ann&eacute;e et de trois mois pour la troisi&egrave;me ann&eacute;e et les ann&eacute;es suivantes.</p>
<p>Il pourra encore &ecirc;tre mis fin au mandat sans que le MANDANT n&rsquo;ait &agrave; respecter un pr&eacute;avis en cas de faute grave du MANDATAIRE, le MANDATAIRE ne pouvant alors pr&eacute;tendre au versement d&rsquo;aucune indemnit&eacute;.</p>
<p>Il en va de m&ecirc;me en cas de non-paiement des redevances pr&eacute;vues, (factures des outils informatiques ou de passerelles, objets publicitaires&hellip;), omissions de d&eacute;clarations des transactions, d&eacute;faut de r&egrave;glement et/ou d&rsquo;inscription &agrave; l&rsquo;URSSAF, d&eacute;faut d&rsquo;assurance R.C.P., non r&egrave;glement des factures dues &agrave; un tiers pour son activit&eacute; professionnelle et en cas de non r&eacute;alisation du chiffre d&rsquo;affaires minimum 20 000&euro; HT annuel, &eacute;tant pr&eacute;cis&eacute; que la rupture du contrat deviendra d&eacute;finitive huit jours apr&egrave;s une mise en demeure rest&eacute;e totalement ou partiellement infructueuse.</p>
<p>&nbsp;</p>
<p><strong><u>Article 5 : DROIT SUR COMMISSIONS APRES CESSATION DU CONTRAT</u></strong></p>
<p><strong><u>Droit de suite en cas de d&eacute;mission / cessation du contrat par une autre proc&eacute;dure</u></strong></p>
<p>Pendant la p&eacute;riode de pr&eacute;avis Styl&rsquo;Immo se r&eacute;serve le droit de mettre en place une organisation sp&eacute;cifique concernant l&rsquo;acc&egrave;s aux outils informatiques. Les flux d&rsquo;entr&eacute;e et de sortie d&rsquo;informations pendant cette p&eacute;riode seront g&eacute;r&eacute;s par le si&egrave;ge et transmis au commercial. D&egrave;s la cessation du contrat tous les acc&egrave;s aux outils informatiques seront coup&eacute;s.</p>
<p>Le mandataire b&eacute;n&eacute;ficie apr&egrave;s cessation du pr&eacute;sent contrat d&rsquo;un droit de suite soumis aux r&egrave;gles cumulatives suivantes&nbsp;:&nbsp;</p>
<ul>
<li>Avec sa lettre de d&eacute;mission le mandataire devra fournir une liste exhaustive des mandats et affaires en cours avec leur date de validit&eacute;, toutes les coordonn&eacute;es permettant de joindre le mandant, l&rsquo;&eacute;tat d&rsquo;avancement de l&rsquo;affaire (en n&eacute;gociation, sous offre, contre-offre, offre contre-sign&eacute;e, compromis pr&eacute;vu, compromis sign&eacute;, dates pr&eacute;vues pour compromis et/ou acte authentique) ainsi que toutes les informations dont il dispose concernant ces affaires. Aucun mandat/affaire ne figurant pas sur cette liste ne pourra donner lieu &agrave; une quelconque r&eacute;mun&eacute;ration. De m&ecirc;me l&rsquo;absence de cette liste rendra caduque tout droit de suite.</li>
<li>La dur&eacute;e du droit de suite est de 6 (six) mois &agrave; compter de la date de cessation du contrat.</li>
<li>Aucune r&eacute;mun&eacute;ration ne pourra &ecirc;tre due, et ce en aucun cas, au mandataire au titre d&rsquo;une affaire dont la signature de l&rsquo;acte authentique aura lieu apr&egrave;s expiration du d&eacute;lai du droit de suite d&eacute;fini ci-dessus.</li>
<li>Dans tous les cas les affaires devront &ecirc;tre la suite et la cons&eacute;quence directes du travail effectu&eacute; par le mandataire pendant l'ex&eacute;cution du pr&eacute;sent contrat.</li>
<li>Le mandataire renonce express&eacute;ment &agrave; ne pas commercialiser apr&egrave;s sa d&eacute;mission, ou la cessation de son contrat en cas de rupture par une autre proc&eacute;dure, directement ou indirectement (y compris par/pour des soci&eacute;t&eacute;s, agences, r&eacute;seaux concurrents avec lesquels il serait engag&eacute; contractuellement), les mandats/affaires Styl&rsquo;Immo qui sont sur sa liste exhaustive de commercial &agrave; la date de sa d&eacute;mission. Un oubli, volontaire ou involontaire, d&rsquo;un mandat/d&rsquo;une affaire Styl&rsquo;Immo sur cette liste ne modifie en rien cette renonciation.</li>
<li>Le montant de la r&eacute;mun&eacute;ration est d&eacute;fini selon les cas suivants&nbsp;:</li>
<li>1<sup>er</sup> cas&nbsp;: l&rsquo;acte authentique est sign&eacute; pendant la p&eacute;riode de pr&eacute;avis mais pas encore encaiss&eacute;, alors la commission est due dans son int&eacute;gralit&eacute; d&egrave;s encaissement par {{$parametre->raison_sociale}}.</li>
<li>2&egrave; cas&nbsp;: le compromis est sign&eacute; pendant la p&eacute;riode de pr&eacute;avis et l&rsquo;acte authentique est sign&eacute; apr&egrave;s la cessation du contrat, et ce <u>sans</u> aucune intervention de {{$parametre->raison_sociale}} Styl&rsquo;Immo et/ou l&rsquo;un de ses mandataires &agrave; quelque niveau que ce soit pour permettre la r&eacute;alisation du compromis et/ou de l&rsquo;acte authentique, alors la commission est due dans son int&eacute;gralit&eacute;.</li>
<li>3&egrave; cas&nbsp;: comme le 2&egrave; cas, mais <u>avec</u> intervention de {{$parametre->raison_sociale}} Styl&rsquo;Immo et/ou l&rsquo;un de ses mandataires &agrave; quelque niveau que ce soit pour permettre la r&eacute;alisation du compromis et/ou de l&rsquo;acte authentique, alors la commission du mandataire sera de 20% (vingt pour cent) de la commission d&rsquo;agence.</li>
<li>4&egrave; cas&nbsp;: le compromis ET l&rsquo;acte authentique sont sign&eacute;s apr&egrave;s la cessation du contrat mais avant l&rsquo;expiration du d&eacute;lai du droit de suite, et ce <u>sans</u> aucune intervention de {{$parametre->raison_sociale}} Styl4immo et/ou l&rsquo;un de ses mandataires &agrave; quelque niveau que ce soit pour permettre la r&eacute;alisation du compromis et/ou de l&rsquo;acte authentique, alors la commission sera de 50% (cinquante pour cent) de la commission d&rsquo;agence.</li>
<li>5&egrave; cas&nbsp;: comme le 4&egrave; cas, mais <u>avec</u> intervention de {{$parametre->raison_sociale}} Styl&rsquo;Immo et/ou l&rsquo;un de ses mandataires &agrave; quelque niveau que ce soit pour permettre la r&eacute;alisation du compromis et/ou de l&rsquo;acte authentique, alors la commission du mandataire sera de 20% (vingt pour cent) de la commission d&rsquo;agence.</li>
<li>6&egrave; cas&nbsp;: la signature du compromis et de la vente ont lieu avant la fin du d&eacute;lai du droit de suite, et ce avec un acqu&eacute;reur qui n&rsquo;est <u>pas</u> sur la liste du mandataire, alors la commission du mandataire sera de 20% (vingt pour cent) de la commission d&rsquo;agence.</li>
</ul>
<p>&nbsp;</p>
<p><strong><u>Article 6&nbsp;: CONDITIONS PARTICULIERES</u></strong></p>
<p>Le MANDATAIRE s&rsquo;engage &agrave; respecter les dispositions de la loi du 02 Janvier 1970 et du d&eacute;cret d'application N&deg;72-678 du 20 Juillet 1972 modifi&eacute; par le d&eacute;cret N&deg;95-818 du 29 Juin 1995 et le d&eacute;cret N&deg;2005-1315 du 21 octobre 2005 concernant les professions immobili&egrave;res dont il d&eacute;clare avoir pris connaissance.</p>
<p>Il s'oblige &agrave; solliciter &agrave; la date anniversaire, aupr&egrave;s de son MANDANT, le renouvellement de son attestation CCI pr&eacute;vue &agrave; l'article 9 du d&eacute;cret du 20 juillet 1972 et au plus tard 3 mois avant la date anniversaire.</p>
<p>Le d&eacute;faut de demande de renouvellement de sa part sera consid&eacute;r&eacute; comme une cause de rupture de son seul fait.</p>
<p>Ledit contrat deviendrait caduc si une d&eacute;cision administrative ou pr&eacute;fectorale en annulait ult&eacute;rieurement les dispositions, sans indemnit&eacute; pour le MANDATAIRE.</p>
<p>Il s'engage d'autre part &agrave; accepter la cession du pr&eacute;sent contrat dans son int&eacute;gralit&eacute; &agrave; toute autre personne physique ou morale rempla&ccedil;ant le MANDANT et sans changement des obligations r&eacute;ciproques des parties m&ecirc;me en cas de changement de d&eacute;nomination commerciale.</p>
<p>Le MANDATAIRE accepte express&eacute;ment de travailler dans les m&ecirc;mes conditions et sous une autre d&eacute;nomination commerciale si le MANDANT le lui demande par lettre recommand&eacute;e avec demande d'avis de r&eacute;ception en respectant un pr&eacute;avis d'un mois.</p>
<p>&nbsp;</p>
<p><strong><u>Article 7&nbsp;: FIN DU CONTRAT</u></strong></p>
<p>D&egrave;s la rupture du contrat pour quelque cause que ce soit, le MANDATAIRE sera tenu de remettre au MANDANT son attestation d&eacute;livr&eacute;e par la CCI ainsi que tous les documents fournis par lui.</p>
<p>Il ne pourra plus continuer &agrave; exploiter les sigles et marques du MANDANT qui restent la propri&eacute;t&eacute; exclusive de Monsieur Jean-Pierre VASILE.</p>
<p>Il fera dispara&icirc;tre imm&eacute;diatement toutes les mentions et inscriptions comprenant ces derni&egrave;res.</p>
<p>En cas de non-ex&eacute;cution, il devra payer une astreinte de 150 &euro; HT (cent cinquante euros hors taxes) par jour de retard ou d'inex&eacute;cution partielle.</p>
<p>Le MANDATAIRE s&rsquo;engage &agrave; s&rsquo;acquitter du solde des abonnements annuels.</p>
<p>&nbsp;</p>
<p><strong><u>Article 8&nbsp;: OBLIGATIONS A LA CHARGE DU MANDANT</u></strong></p>
<p>Le MANDANT mettra &agrave; disposition du MANDATAIRE&nbsp;:</p>
<ul>
<li>Un ensemble de fournitures contenant des imprim&eacute;s de base n&eacute;cessaires &agrave; l'exercice de ses fonctions et la documentation utile &agrave; l'activit&eacute; de n&eacute;gociateur en immobilier&nbsp;;</li>
<li>Un site Internet national dont chaque contact obtenu est redirig&eacute; vers le mail du mandataire gr&acirc;ce au polygramme personnel ;</li>
<li>Une adresse e-mail personnalis&eacute;e r&eacute;serv&eacute;e au MANDATAIRE.</li>
<li>Les codes d&rsquo;acc&egrave;s &agrave; un serveur vocal d&rsquo;attribution de num&eacute;ros de mandats (REGISTRE DES MANDATS).</li>
<li>Votre premi&egrave;re commande de cartes de visite et de flyers personnalis&eacute;s sera prise en charge par le r&eacute;seau (pack de d&eacute;marrage).</li>
</ul>
<p>Le MANDATAIRE pourra obtenir tous documents de base n&eacute;cessaires &agrave; l'exercice de ses fonctions &agrave; partir du logiciel de transactions mais il pourra, s'il le souhaite, utiliser les imprim&eacute;s professionnels &eacute;dit&eacute;s par les imprimeurs sp&eacute;cialis&eacute;s reconnus par la profession.</p>
<p>Dans tous les cas, il s'interdit de communiquer les codes d'acc&egrave;s qui lui seront confi&eacute;s par le MANDANT.</p>
<p>&nbsp;</p>
<p><strong><u>Article 9&nbsp;: OBLIGATIONS A LA CHARGE DU MANDATAIRE</u></strong></p>
<p><strong><u>Article 9.1&nbsp;: Obligations g&eacute;n&eacute;rales &agrave; la charge du mandataire</u></strong></p>
<ul>
<li>La cr&eacute;ation et la mise en place de comptes sur les outils informatiques et passerelles publicitaires est offerte par le r&eacute;seau STYL&rsquo;IMMO selon les conditions pr&eacute;vues &agrave; l&rsquo;annexe 3 du pr&eacute;sent contrat.</li>
</ul>
<p>Cette prestation comprend&nbsp;: un logiciel de transactions immobili&egrave;res d&eacute;velopp&eacute; par le fournisseur informatique choisit par le r&eacute;seau STYL&rsquo;IMMO&nbsp;; un compte dans le registre de mandats choisi par le MANDANT&nbsp;; un compte sur l&rsquo;outil de pige choisi par le MANDANT&nbsp;; ainsi que les acc&egrave;s &agrave; diverses passerelles de publicit&eacute; avec lesquelles la soci&eacute;t&eacute; {{$parametre->raison_sociale}} a obtenu des contrats cadre de partenariat nationaux, pour la diffusion d&rsquo;annonces immobili&egrave;res sur internet. Les licences restant &agrave; la charge du MANDATAIRE.</p>
<p>Ces prestations d&rsquo;ouverture de comptes sont prises en charge par le MANDANT.</p>
<ul>
<li>Le MANDATAIRE s&rsquo;engage express&eacute;ment &agrave; utiliser syst&eacute;matiquement et de fa&ccedil;on exhaustive le logiciel de transactions immobili&egrave;res tant bien pour les vendeurs de biens que pour les acqu&eacute;reurs&nbsp;; il en est de m&ecirc;me pour le logiciel de registre des mandats.</li>
<li>Les licences d&rsquo;utilisation des logiciels de transaction et de pige ainsi que les publicit&eacute;s (diffusion des annonces) sur les passerelles seront factur&eacute;es mensuellement.</li>
<li>La facturation des outils informatiques et publicitaires se fera selon la tarification &eacute;tablie en annexe 3 ci-jointe. La Soci&eacute;t&eacute; {{$parametre->raison_sociale}} s&rsquo;&eacute;vertue &agrave; obtenir des tarifs pr&eacute;f&eacute;rentiels aupr&egrave;s de ses partenaires n&eacute;anmoins, ces tarifs peuvent &ecirc;tre amen&eacute;s &agrave; &ecirc;tre modifi&eacute;s &agrave; tout moment en fonction des n&eacute;gociations avec nos fournisseurs et des changements impos&eacute;s ceux-ci.</li>
<li>Ces prestations devront &ecirc;tre r&eacute;gl&eacute;es selon les modalit&eacute;s pr&eacute;vues &agrave; l&rsquo;annexe 3 du pr&eacute;sent contrat.</li>
</ul>
<p><strong><u>Article 9.2&nbsp;: Obligations particuli&egrave;res &agrave; la charge du mandataire</u></strong></p>
<p><strong><u>Article 9.2.1&nbsp;: Obligations du mandataires li&eacute;es aux commissions directes</u></strong></p>
<p>1&deg;/ - Le MANDATAIRE ne pourra en aucun cas ouvrir un bureau pour recevoir sa client&egrave;le ni apposer de pancarte publicitaire en fa&ccedil;ade de son domicile, le pr&eacute;sent contrat ne l'autorisant pas &agrave; exploiter un bureau, une succursale, agence ou un &eacute;tablissement secondaire comme pr&eacute;vu &agrave; l'article 9 du d&eacute;cret du 20 Juillet 1972. Il s'interdit de recevoir la client&egrave;le &agrave; son domicile.</p>
<p>2&deg;/ - Le MANDATAIRE fera sa publicit&eacute; &agrave; ses frais exclusifs pour les autres passerelles avec lesquelles la SARL {{$parametre->raison_sociale}} n&rsquo;aurait pas conclu de contrat cadre de partenariat, ou pour toute autre forme de publicit&eacute;, en respectant parfaitement la marque, sigle et autres logotypes dans le respect de la charte graphique du MANDANT et en pr&eacute;cisant obligatoirement &laquo;&nbsp;STYL&rsquo;IMMO&nbsp;&raquo; et &laquo;&nbsp;www.stylimmo.com&nbsp;&raquo;suivi de son nom, de son num&eacute;ro de t&eacute;l&eacute;phone portable et du num&eacute;ro de la carte professionnelle du MANDANT ainsi que de l'adresse du MANDANT si cette mention &eacute;tait rendue obligatoire par l'Administration.</p>
<p>Exemple :<strong><em> &laquo;&nbsp;www.stylimmo.com</em></strong><strong><em> &raquo; - M. Philippe Martin </em></strong><strong><em>- T&eacute;l 06 00 00 00 00, - CPAI n&deg; 1155T10Gard.</em></strong></p>
<p>3&deg;/ - Dans le cas o&ugrave; le mandataire voudrait utiliser un site avec une URL personnelle, et apr&egrave;s un accord favorable du mandant, ce site devra contenir :</p>
<ul>
<li>Les mentions l&eacute;gales obligatoires</li>
<li>Un lien en premi&egrave;re page avec le site national du mandant.&nbsp;&laquo;&nbsp;www.stylimmo.com&nbsp;&raquo;&nbsp;</li>
<li>La mention Styl&rsquo;Immo ou Groupe Styl&rsquo;Immo.</li>
<li>Ce site personnel devra comporter le logo Styl&rsquo;Immo &agrave; minima dans la page mentions l&eacute;gales.</li>
</ul>
<p>4&deg;/ - Le mandataire, qu'il ait ou non un site personnel, devra syst&eacute;matiquement diffuser ses annonces sur le site internet national du mandant.</p>
<p>5&deg;/ Le MANDATAIRE assurera &agrave; ses frais exclusifs sa propre contrat->userion t&eacute;l&eacute;phonique et le cas &eacute;ch&eacute;ant son secr&eacute;tariat et s'engage &agrave; respecter les obligations l&eacute;gales et administratives en mati&egrave;re de publicit&eacute; immobili&egrave;re.</p>
<p>6&deg;/ Le MANDATAIRE ne pourra en aucun cas associer les marques et sigles du MANDANT &agrave; un autre site immobilier sur Internet sans l'accord &eacute;crit pr&eacute;alable du MANDANT.</p>
<p>7&deg;/ - Conform&eacute;ment &agrave; la r&eacute;glementation en vigueur toutes les affaires propos&eacute;es en publicit&eacute; et prises &agrave; la vente devront avoir donn&eacute; lieu au pr&eacute;alable &agrave; un mandat de vente d&ucirc;ment enregistr&eacute; sur les registres professionnels obligatoires du MANDANT d&eacute;tenu par le titulaire de la carte professionnelle.</p>
<p>Le MANDATAIRE adressera ses ordres de publicit&eacute; sur son papier commercial qui devra obligatoirement mentionner son num&eacute;ro SIRET ainsi que son num&eacute;ro de T.V.A. Intracommunautaire et sera tenu de r&eacute;gler personnellement les factures correspondantes.</p>
<p>8&deg;&nbsp;/ - Le MANDATAIRE fera parvenir au si&egrave;ge par mail <u>dans les 24 heures</u> (vingt-quatre heures) de leur signature la version num&eacute;ris&eacute;e (recto-verso avec signatures) de chaque mandat de vente, de location, de recherche d&rsquo;un bien et de d&eacute;l&eacute;gation de mandat ou d&rsquo;avenant, puis <u>au plus tard &agrave; la fin du mois en cours</u> l&rsquo;original par courrier. Il remettra l&rsquo;autre exemplaire original du mandat au client (article 72 du d&eacute;cret du 20/07/1972). Il conservera par devers lui une copie de chacun des exemplaires.</p>
<p>Afin de permettre leur enregistrement, tous les mandats pris par le MANDATAIRE devront &ecirc;tre saisis sur l&rsquo;Interface informatique du MANDANT.</p>
<p>9&deg;/ - Le MANDATAIRE ne sera pas habilit&eacute; &agrave; r&eacute;diger des compromis ou des actes sous seings priv&eacute;s ni donner des conseils juridiques. Il s&rsquo;interdit de percevoir directement des commissions, notamment dans le cadre des affaires r&eacute;alis&eacute;es en &laquo;&nbsp;inter-cabinet&nbsp;&raquo;. Ces commissions devront toujours &ecirc;tre r&eacute;gl&eacute;es sur le compte du MANDANT.</p>
<p>10&deg;/ - Tous les compromis r&eacute;dig&eacute;s par devant notaire, avocat ou par le MANDANT devront mentionner les noms du MANDATAIRE et de la soci&eacute;t&eacute; {{$parametre->raison_sociale}} (le MANDANT) et pr&eacute;ciser le num&eacute;ro du mandat, le montant de la commission ainsi que la personne qui devra la r&eacute;gler.</p>
<p>Une copie de chaque compromis sera syst&eacute;matiquement et imm&eacute;diatement envoy&eacute;e au si&egrave;ge du MANDANT d&egrave;s leur signature accompagn&eacute;e d'une &laquo; fiche de renseignements apr&egrave;s compromis &raquo; qui pr&eacute;cisera le nom des parties, l'adresse du bien vendu, le prix de vente, le num&eacute;ro de mandat, le montant de la commission et le nom du Notaire en charge des actes.</p>
<p>Dans tous les cas, le MANDATAIRE s&rsquo;interdit de recevoir directement une commission de la part d&rsquo;un notaire, d&rsquo;un client ou d&rsquo;un confr&egrave;re.</p>
<p>11&deg;/ - Le MANDATAIRE ne pourra pr&eacute;tendre &agrave; ni exiger aucun bureau dans les locaux ou succursales du MANDANT que ce soit pour recevoir ses clients ou pour y r&eacute;diger ses correspondances, sauf accord ponctuel de ce dernier.</p>
<p>12&deg;/ - Le MANDATAIRE devra s&rsquo;&eacute;quiper&nbsp;:</p>
<ul>
<li>D&rsquo;un t&eacute;l&eacute;phone portable et mentionner le num&eacute;ro d&rsquo;appel correspondant sur toutes ses publicit&eacute;s.</li>
<li>Du logiciel informatique sp&eacute;cifique au MANDANT et pourra diffuser toutes ses affaires prises &agrave; la vente sur le site Internet du MANDANT.</li>
<li>D&rsquo;un ordinateur enti&egrave;rement &eacute;quip&eacute; et param&eacute;tr&eacute; lui permettant ainsi d'&ecirc;tre imm&eacute;diatement op&eacute;rationnel.</li>
</ul>
<p>13&deg;/ - Le MANDATAIRE devra se faire faire un tampon commercial de dimension 60x35mm avec le sigle "STYL&rsquo;IMMO" en pr&eacute;cisant obligatoirement son nom suivi de la mention &laquo;&nbsp;Agent Commercial Ind&eacute;pendant&nbsp;&raquo;, son num&eacute;ro de t&eacute;l&eacute;phone portable, son num&eacute;ro SIRET et le num&eacute;ro de la carte professionnelle du MANDANT (CPAI n&deg;1155T10Gard).</p>
<p>14&deg;/ - Le MANDATAIRE pourra c&eacute;der son portefeuille &agrave; toutes personnes capables respectant les causes dudit contrat. Il devra au pr&eacute;alable signifier au MANDANT cette cession par lettre recommand&eacute;e avec demande d'avis de r&eacute;ception, avec indication du prix. Le MANDANT pourra faire jouer son droit de pr&eacute;emption sur ladite cession dans le d&eacute;lai d'un mois.</p>
<p>15&deg;/ - Le non-respect d'une seule des obligations et conventions sus &eacute;nonc&eacute;es entra&icirc;nera la rupture imm&eacute;diate du pr&eacute;sent contrat sans aucun recours et sans indemnit&eacute;, les parties reconnaissant que ces conditions sont un &eacute;l&eacute;ment essentiel de leur accord r&eacute;ciproque et que leur non-respect sera assimil&eacute; &agrave; une faute professionnelle.</p>
<p>16&deg;/ - Le MANDATAIRE d&eacute;clare qu&rsquo;il est libre de tout engagement avec un professionnel de l&rsquo;immobilier autre que le MANDANT.</p>
<p><strong><u>Article 9.2.2&nbsp;: Obligations du mandataires li&eacute;es aux commissions indirectes</u></strong></p>
<p>Aucune obligation concernant les commerciaux pr&eacute;sent&eacute;s au r&eacute;seau.</p>
<p>&nbsp;</p>
<p><strong><u>Article 10&nbsp;: JURIDICTION COMPETENTE</u></strong></p>
<p>Le Tribunal mat&eacute;riellement comp&eacute;tent dans le ressort duquel le MANDANT a son si&egrave;ge social sera seul comp&eacute;tent pour tout litige relatif &agrave; l'interpr&eacute;tation et/ou &agrave; l'ex&eacute;cution du pr&eacute;sent contrat et de ses suites.</p>
<p>&nbsp;</p>
<p><strong><u>Article 11&nbsp;: LISTE DES ANNEXES JOINTES AU PRESENT CONTRAT</u></strong></p>
<p>Annexe 1&nbsp;: Bar&egrave;me de commissionnement direct</p>
<p>Annexe 2&nbsp;: Bar&egrave;me de commissionnement indirect</p>
<p>Annexe 3&nbsp;: Engagement &agrave; payer</p>
<p>Annexe 4&nbsp;: Bar&egrave;me d&rsquo;honoraires</p>
<p>LE PR&Eacute;SENT CONTRAT A &Eacute;T&Eacute; &Eacute;TABLI EN DEUX EXEMPLAIRES DONT UN</p>
<p>EST REMIS AU MANDATAIRE QUI LE RECONNAIT EXPRESS&Eacute;MENT</p>
<p>&nbsp;</p>
<p><strong><u>ENGAGEMENT SUR L'HONNEUR</u></strong></p>
<p><em>Je soussign&eacute;, d&eacute;clare par la pr&eacute;sente, ma ferme intention de ne recevoir, de mani&egrave;re directe ou indirecte, aucun fonds, effet ou valeur &agrave; l'occasion des op&eacute;rations de &laquo;&nbsp;TRANSACTIONS &raquo; que je compte effectuer pour le compte de mon mandant, la soci&eacute;t&eacute; {{$parametre->raison_sociale}} domicili&eacute;e {{$parametre->adresse}}.</em></p>
<p><em>En particulier, je suis inform&eacute; que le fait de recevoir un ch&egrave;que ou une valeur &agrave; l&rsquo;ordre d'un tiers (vendeur, notaire, etc.) constitue un acte de maniement de fonds et que le simple fait d'un transit de ce ch&egrave;que ou de cette valeur, m&ecirc;me occasionnel, entre mes mains, me rattacherait &agrave; la cat&eacute;gorie des interm&eacute;diaires maniant des fonds, au sens des textes et de leur interpr&eacute;tation jurisprudentielle.</em></p>
<p><em>Je me refuse donc d'effectuer de telle r&eacute;ception.</em></p>
<p><em>Par ailleurs, je reconnais que je ne suis pas habilit&eacute; &agrave; &eacute;tablir de facture de commission &agrave; l'attention des clients (acheteurs ou vendeurs) ni en mon nom ni en celui de mon MANDANT.</em></p>
<p><em>J'ai connaissance enfin que la violation de ma part du pr&eacute;sent engagement serait de nature &agrave; remettre en cause la validit&eacute; de mon contrat de mandataire et engagerait ma propre responsabilit&eacute; civile professionnelle.</em></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Fait &agrave; Bagnols-sur-C&egrave;ze le&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date de d&eacute;but d&rsquo;activit&eacute;&nbsp;:</p>
<p>Mme OCCELLI Christine&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$contrat->user->civilite}} {{$contrat->user->nom}} {{$contrat->prenom}}.</p>
<p>LE MANDANT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LE MANDATAIRE</p>
<p>Lu et approuv&eacute;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lu et approuv&eacute;,</p>
<p>Bon pour mandat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bon pour acceptation de mandat</p>

</body>