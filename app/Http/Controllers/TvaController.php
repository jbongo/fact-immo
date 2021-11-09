<?php

namespace App\Http\Controllers;

use App\Tva;
use App\Mail\EncaissementFacture;
use App\Facture;
use App\User;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;


class TvaController extends Controller
{
    /**
     * tests
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {

        $merger = new Merger;
        $merger->addFile('one.pdf');
        // $merger->addFile('two.pdf');
        $merger->addFile('three.pdf');
        $createdPdf = $merger->merge();
        return new Response($createdPdf, 200, array('Content-Type' => 'application/pdf'));
dd($createdPdf);



        $mandataires = User::where('role','mandataire')->orderBy('nom')->get();
        
        foreach ($mandataires as $mandataire) {
            if(($mandataire->contrat != null && $mandataire->contrat->a_demission == false && $mandataire->contrat->est_fin_droit_suite == false) ) {
            
                echo $mandataire->email.", $mandataire->email_perso,<br>";
            }
        }


dd("cc");

      $ligne = '
      "1,""0"",""organization"",""public"",""Services"","""","""","""","""","""","""","""",""WebCdesign"",""Création site internet"",""Cédric"",""MONNOT"","""","""","""","""","""","""","""","""","""","""","""","""","""",""11 route des Vignerons"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.068700000000"",""4.654160000000"",""public"","""","""","""","""",""06 28 58 29 44"",""public"","""","""",""contact@webcdesign.com"",""public"","""","""","""","""",""https://webcdesign.com"",""webCdesign"",""public"","""","""",""Société de création de sites Web, réservation de nom de domaine, hébergement, messagerie, certificat SSL, référencement, ..."","""","""",""http://2021.saintvictorlacoste.com/maquette2/wp-content/uploads/connections-images/webcdesign/logo_webcdesign.png""	
        "2,""0"",""organization"",""public"",""Services,Immobilier"","""","""","""","""","""","""","""",""optimhome"",""Agent immobilier"",""Daniel"",""Specchio"",""2 rue Balzac"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064100000000"",""4.647090000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 74 94 96 45"",""public"",""daniel.specchio@hopimhome.com"",""public"","""","""","""","""","""","""",""https://www.optimhome.com/conseillers/specchio"",""https://www.optimhome.com/conseillers/specchio"",""public"","""","""","""","""","""",""""	
        "3,""0"",""individual"",""public"",""Santé"","""","""",""Roland"","""",""GOURDON"","""",""Médecin généraliste"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""6 avenue de la Libération"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064600000000"",""4.640310000000"",""public"","""","""",""04 66 50 27 07"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "4,""0"",""individual"",""public"",""Santé"","""","""",""Mireille"","""",""FOGELGESANG"","""",""Infirmière"","""","""","""","""",""Rue de Mouillargues"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.066300000000"",""4.658410000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 32 70"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "5,""0"",""individual"",""public"",""Santé"","""","""",""Nathalie"","""",""YOSBERGUE"","""",""Infirmière"","""","""","""","""",""3 rue Lamartine"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.066900000000"",""4.640880000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 05 07"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "6,""0"",""individual"",""public"",""Santé"","""","""",""Hélène"","""",""CHARMASSON"","""",""Infirmière"","""","""","""","""",""8 rue de la grande terre"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.065500000000"",""4.643120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 19 71 18 73"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "7,""0"",""individual"",""public"",""Santé"","""","""",""Claude CARON"","""",""Sophie GARCIA"","""",""Kinésithérapeutes"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""1 impasse Font Hiau"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"",""06 58 47 43 16"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "8,""0"",""organization"",""public"",""Santé"","""","""","""","""","""","""","""",""Taxi VSL"","""",""Taxi"",""Audy"","""","""","""","""","""","""","""","""","""","""","""","""","""",""19 rue de Baracca"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.067900000000"",""4.641060000000"",""public"",""06 66 93 22 93"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "9,""0"",""organization"",""public"",""Santé"","""","""","""","""","""","""","""",""Taxi, Ambulance"","""",""Taxi"",""Tonio"",""16 rue de la Bronque"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.066200000000"",""4.660680000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 30 94 82 58"",""public"","""","""",""04 66 50 12 54"",""public"",""taxitonio@free.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "10,""0"",""organization"",""public"",""Santé"","""","""","""","""","""","""","""",""Pharmacie St Victor"","""",""Stéphanie"",""Couderc"",""9bis Rue de Plaineautier"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 12 15"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "11,""0"",""individual"",""public"",""Santé"","""","""",""Florence"","""",""RAICHON-BERNARD"","""",""Massages - Bien-être - Yoga"","""","""","""","""",""1 impasse Font Hiau"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 62 36 45 42"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "12,""0"",""individual"",""public"",""Santé"","""","""",""Roseline"","""",""ROBERT"","""",""Réflexologue - Hypnothérapie Ericksonienne"","""","""","""","""",""1 impasse Font Hiau"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 17 35 47 56"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "13,""0"",""individual"",""public"",""Santé"","""","""",""Anne"","""",""CHARRET"","""",""Psychologue Psychologue - Sophrologue"","""","""","""","""",""1 impasse Font Hiau"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 15 36 44 50"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "14,""0"",""individual"",""public"",""Santé"","""","""",""Célia"","""",""CARRASCO"","""",""Orthophoniste"","""","""","""","""",""1 impasse Font Hiau"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 98 69 47 51"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
        "15,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Boulangerie"","""",""Jean-Luc"",""Forget"",""7 rue de Plaineautier"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062200000000"",""4.640120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 05 22"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""
        "16,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Café restaurant"","""",""Café restaurant"",""de l\'Industrie"",""13 place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 31 61"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""Café, bar, brasserie, restaurant"","""","""",""""	
        "17,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Commerce ambulant"","""",""Pizza"",""CHRIS"",""Place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 09 39 45 68"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""Vente pizza jeudi, vendredi et samedi soir."","""","""",""""	
        "18,""0"",""individual"",""public"",""Commerces"","""","""",""CHEZ"","""",""ROBERTO"","""","""",""Commerce ambulant"","""","""","""",""Place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 77 08 97 35"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""Vente pizza dimanche soir."","""","""",""""	
        "19,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Commerce ambulant"","""",""Régal"",""PIZZA"",""Place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290 Saint Victor la Coste"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 12 07 58 20"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""Vente pizza, snack, baraque à frites le mardi soir."","""","""",""""	
        "20,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Salon de coiffure"","""",""Salon"",""Frimousse"",""9 place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 12 41"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "21,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Salon de coiffure LB"","""",""Laurence"",""BEL"","""","""","""","""","""","""","""","""","""","""","""","""","""",""4 Bis chemin du chardonay"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""",""06.65.78.99.19"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""
        "22,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Tabac, presse"","""",""SAVO Carine"",""et Laetitia"",""18 place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 44 32"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""Tabac presse, journaux, magazine, jeux, loto"","""","""",""""
        "23,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Vival"","""",""Mr"",""et Mme GILLES"",""Place de la Mairie"","""","""","""","""","""",""St Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 34 47 01 74"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""
        
        "24,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""ABS ELEC"",""Dépannage, électricité générale."",""Daniel"",""Proux"",""8 chemin des Lonnes"","""","""","""","""","""",""St Victor la Coste"","""",""30290"","""",""44.069000000000"",""4.650740000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 14 85 06 10"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""Devis gratuit et assurance décennale."","""","""","""""	
        "25,""0"",""individual"",""public"",""Artisanat"","""","""",""Sylvette"","""",""DAUCHET"","""",""Artiste peintre"","""","""","""","""",""19 rue de la Roquette"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061900000000"",""4.654740000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06.75.79.15.46"",""public"","""","""","""","""",""sylvette.dauchet@wanadoo.fr"",""public"","""","""","""","""","""","""",""http://www.sylvedauchet.fr/"",""voir le site internet"",""public"","""","""","""","""","""","""""	
        "26,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""Atelier AME&CO couture"","""",""Amelie"",""Carette"",""8 rue des rocs"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.061800000000"",""4.639640000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06.38.52.43.91"",""public"","""","""",""atelier.ameliecouture@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""",""Retouche - Création - Customisation - Repassage" "Atelier AME&amp"	"CO"","""","""","""""
        "27,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""Design Métallerie"","""",""Benjamin"",""LAURENT"","""","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""07.88.02.72.17"",""public"","""","""",""laurent.serrurerie30@gmail.com"",""public"","""","""","""","""","""","""",""http://design-metallerie.com/"",""voir le site internet"",""public"","""","""","""","""","""","""""	
        "28,""0"",""individual"",""public"",""Artisanat"","""","""",""Éric"","""",""SIGMANN"","""",""Jardinier qualifié"","""","""","""","""","""","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""private"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06.09.96.29.95"",""public"","""","""",""eric.sigmann@sfr.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "29,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""Maçonnerie"","""",""Palus"",""Construction PCR"",""18 rue du Vernet"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.068500000000"",""4.658910000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 33 01 17"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "30,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""Menuiserie métallique, ferronnerie, soudure tuyauterie"","""",""Laurent"",""Jean"",""25 route d\'Avignon"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064100000000"",""4.656760000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 32 35"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "31,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""Menuiserie, ébénisterie"","""",""Pascal"",""Lazaro"",""8 rue du Vernet"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.068500000000"",""4.658910000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 38 34"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "32,""0"",""organization"",""public"",""Artisanat"","""","""","""","""","""","""","""",""Nelly Peinture"","""",""Nelly"",""Charras"","""","""","""","""","""","""",""St Victor la Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""07 81 12 38 36"",""public"","""","""",""charras.nelly@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "33,""0"",""individual"",""public"",""Artisanat"","""","""",""David"","""",""Pouzol"","""",""Peinture"","""","""","""","""",""20 rue de Bouchoulier"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061000000000"",""4.646340000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 46 60 34 90"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "34,""0"",""individual"",""public"",""Agriculture"","""","""",""Domaine"","""",""Bourbonnois"","""",""Producteur, vente de vin et champagne"","""","""","""","""",""Chemin des Vignes"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.069700000000"",""4.649120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 06 99 54 49"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "35,""0"",""organization"",""public"",""Industrie"","""","""","""","""","""","""","""",""Fourniture et montage de gaines aéroliques"","""",""SARL"",""DENIZE"",""24 rue de Pied Bourquin"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061700000000"",""4.651970000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 89 32 97"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "36,""0"",""organization"",""public"",""Agriculture"","""","""","""","""","""","""","""",""Producteur, vente directe de vin"","""",""Carmelisa"","""",""La Grande Rouge"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 12 32 84 84"",""public"","""","""",""gilles.leclerc5@orange.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "37,""0"",""organization"",""public"",""Agriculture"","""","""","""","""","""","""","""",""Travaux agricoles"","""",""Guy"",""Roux"",""55 route de Saint Laurent des Arbres"","""","""","""","""","""",""aint Victor la Coste"","""",""30290 S"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 45 65"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "38,""0"",""organization"",""public"",""Agriculture"","""","""","""","""","""","""","""",""Vente de vin et champagne"","""",""Grine"",""Abel"",""18 rue du Puits de Laudun"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064700000000"",""4.641380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 36 10"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "39,""0"",""organization"",""public"",""Industrie"","""","""","""","""","""","""","""",""Mécanique industrielle, maintenace"",""Maintenance"","""","""",""16 impasse de la Roquette"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062800000000"",""4.655290000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 15 91"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "40,""0"",""organization"",""public"",""Urgences"","""","""","""","""","""","""","""",""Centre Hospitalier"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""7 Avenue Alphonse Daudet"","""","""","""","""","""",""Bagnols sur Cèze"","""",""30200"","""",""44.152900000000"",""4.613200000000"",""public"","""","""","""","""",""04 66 79 10 11"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "41,""0"",""organization"",""public"",""Urgences"","""","""","""","""","""","""","""",""Clinique La Garaud"",""Clinique chirurgicale"","""","""",""217 Rue André Penchenier"","""","""","""","""","""",""Bagnols sur Cèze"","""",""30200"","""",""44.151200000000"",""4.609310000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 90 60 60"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "42,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Carmélisa"",""Producteur, vente directe de vins"",""Gilles"",""Leclerc"",""La Grange Rouge"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 12 32 84 84"",""public"","""","""","""","""",""gilles.leclerc5@orange.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "43,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Clémence"",""Producteur, vente directe de vins"",""Nicolas"",""Arvieux"",""2 place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 39 26"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "44,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Domaine de la Touline"","""",""Francis"",""Bégagnon"",""Chemin des Cadinières"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.069100000000"",""4.657280000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 50 20 76 03"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "45,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Domaine du Prieuré de Mayran"",""Producteur, vente directe de vins"",""David"",""Roux"",""55 route de Saint Laurent des Arbres"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.649790000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 45 65"",""public"","""","""",""david-roux@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "46,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Domaine Pélaquié"",""Producteur, vente directe de vins"",""Luc"",""Pélaquié"",""7 rue du Vernet"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.068500000000"",""4.658910000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 06 04"",""public"","""","""","""","""","""","""","""","""","""","""",""https://www.domaine-pelaquie.com/fr/"",""www.domaine-pelaquie.com"",""public"","""","""","""","""","""","""""	
        "47,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Domaine Vignal"",""Producteur, vente directe de vins"","""",""Vignal"",""15 chemin des Cadinières"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.069100000000"",""4.657280000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 03 34"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "48,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Estournel Rémy"",""Producteur, vente directe de vins"",""Rémy"",""Estournel"",""13 rue de Plaineautier"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062200000000"",""4.640120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 21 85"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "49,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Domaine Bourbonnois"",""Producteur, vente de vin et champagne"","""","""",""Chemin des Vignes"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.069700000000"",""4.649120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 06 99 54 49"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "50,""0"",""organization"",""public"",""Caves"","""","""","""","""","""","""","""",""Vente vin et champagne"",""Vente vin et champagne"",""Abel"",""Grine"",""18 rue du Puits de Laudun"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064700000000"",""4.641380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 36 10"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        "51,""0"",""organization"",""public"",""Restauration"","""","""","""","""","""","""","""",""Café restaurant l\'Industrie"","""","""","""",""13 place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 31 61"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
        
        
      "52,""0"",""organization"",""public"",""Restauration"","""","""","""","""","""","""","""",""PIZZA CHRIS"",""Commerce ambulant"","""","""",""Place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 09 39 45 68"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""Vente de pizzas jeudi, vendredi et samedi soir."","""","""","""""	
"53,""0"",""organization"",""public"",""Restauration"","""","""","""","""","""","""","""",""CHEZ ROBERTO"",""Commerce ambulant"","""","""",""Place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 77 08 97 35"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""Vente de pizzas dimanche soir."","""","""","""""	
"54,""0"",""organization"",""public"",""Restauration"","""","""","""","""","""","""","""",""RÉGAL PIZZA"",""Commerce ambulant"",""Nicolas"",""Debuyser"",""Place de la Mairie"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 12 07 58 20"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"55,""0"",""organization"",""public"",""Hébergement"","""","""","""","""","""","""","""",""Chambre d\'hôtes+gîte"",""Hébergement"",""Henri"",""Pock"",""3 rue du Vernet"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.068500000000"",""4.658910000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 30 42"",""public"","""","""",""henri.pock@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""",""Deux chambres pour deux personnes. Cour fermée et arborée. Buanderie avec machine à laver et sèche-linge à disposition. Barbecue en commun avec le propriétaire. <img class="alignnone wp-image-10236" src="http://2021.saintvictorlacoste.com/maquette2/wp-content/uploads/2021/10/cle1.jpg" width="150" height="66" /> "","""","""","""""	
"56,""0"",""organization"",""public"",""Hébergement"","""","""","""","""","""","""","""",""Gîte La Magnanerie"",""Hébergement"","""",""Jouve"",""9 Rue Léon Bouchet"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061800000000"",""4.643060000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 64 69 59 91"",""public"",""04 66 50 36 69"",""public"","""","""",""yasmine.jouve@sfr.fr"",""public"","""","""",""https://www.facebook.com/GiteLaMagnanerie"",""public"","""","""","""","""","""","""","""",""Maison d\'architecture paysanne du 17ème dans quartier calme du vieux village médiéval de Saint Victor la Coste. Maison chaleureuse avec jardin sans vis à vis de 300 m2, 2 terrasses, plancha et vue panoramique sur le château et les Cévennes.Espace piscine de 600 m2 sécurisé (10 m x 5 m + pataugeoire). Jeux d\'enfants, ping-pong et cuisine d\'été équipée. La maison dispose de 3 chambres (8 couchages),  de 2 salles de bain, une cuisine ouverte sur la salle à manger et le salon.	Wifi, TV Draps et linge de maison fournis.	Au cœur du vignoble des Côtes du Rhône, à 20mn d\'Avignon, Uzès, Orange, les gorges de l\'Ardèche et du Gardon, Le Pont du Gard et à 45mn de Nimes. Auroroute à 10mn : A9 Roquemaure ou Remoulins. "","""","""",""""	
"57,""0"",""organization"",""public"",""Hébergement"","""","""","""","""","""","""","""",""Mas du Vieux Chemin"",""Gite, studio et chambre d\'hôtes"",""Anne-Marie"",""CHARMASSON"",""1 rue du Vieux Chemin"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062400000000"",""4.643600000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 71 77 07 77"",""public"",""04 66 50 43 21"",""public"","""","""",""charmassonf@wanadoo.fr"",""public"","""","""","""","""","""","""",""https://www.masduvieuxchemin.com/"",""www.masduvieuxchemin.com"",""public"","""","""",""Dans une ancienne maison vigneronne du 18ème : - Studio,2/3 personnes rez de chaussée dans maison principale. une large baie ouvre sur le château. Possibilité de louer en chambre d\'hôtes - Gîte, 5 personnes cuisine repas avec cheminée, deux chambres, terrasse et jardins arborés et indépendants	
	
- Chambre d\'hôtes, 2 personnes, WC et salle de bains particuliers, terrasse et entrée indépendantes "<img class="alignnone wp-image-10237" src="http://2021.saintvictorlacoste.com/maquette2/wp-content/uploads/2021/10/cle2.jpg" width="150" height="82" /></div>"","""","""","""""	
"58,""0"",""organization"",""public"",""Hébergement"","""","""","""","""","""","""","""",""Maison de village"",""Hébergement"","""",""Labrugnas"",""2 rue de la Carrière"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061400000000"",""4.643620000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 25 49 75 66"",""public"",""04 66 50 36 48"",""public"","""","""",""odette.labru@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""",""	60 m², confortable et entièrement équipée.	1er étage : terrasse avec vue dégagée sur le centre village et le château. Grande pièce salle à manger/salon comprenant 2 canapés dont un canapé lit  couchage 130. Téléviseur chaîne TNT.	Cuisine équipée avec lave-vaisselle et lave-linge. Salle d\'eau :  douche à l\'italienne, lavabo et wc. Draps et linge de toilette fournis.	Rez-de-chaussée : chambre 2 personnes équipée d\'un grand lit 1,80m x 2m, 2 chevets, 1 commode et fauteuil, bonnetière et caisson de rangement.	Accès à une piscine autoportante 3m de diamètre. Accueil de 4 personnes, enfant(s) à partir de 5/6 ans en raison du petit muret de la terrasse du 1er étage qui peut être facilement escaladé.Trouver l\'annonce sur : papvacances.fr	abritel.fr annonce 581432 (recherche par référence)	"","""","""","""""	
"59,""0"",""organization"",""public"",""Hébergement"","""","""","""","""","""","""","""",""Mazet datant du XIIIème"",""Hébergement"",""Christine et Dominique"",""Viva"",""19 rue de la Combe"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062000000000"",""4.638840000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 63 67 77 41"",""public"",""04 66 82 64 55"",""public"","""","""",""dominique-viva@orange.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""",""<div class="description tiny">66 m² de plain-pied entièrement rénové, comprenant une cuisine équipée, salon avec clic-clac, 2 chambres avec lits doubles, dans la seconde 2 lits simples + lit pliant. Salle de bain avec douche et lave-linge. matériel pour bébé à disposition.	Terrasse avec salon de jardin et barbecue donnant sur jardin clos. </div>"","""","""","""""	
"60,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""APE"","""",""Angélique"",""MARION"",""26 route du Claux"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063100000000"",""4.645720000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 21 09 64 65"",""public"","""","""","""","""","""","""",""apesaintvictor@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"61,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Association Foyer Saint Victor"","""",""Monique"",""DUMONTEAUX-BRUNEL"",""5 rue de la Combe"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062000000000"",""4.638840000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 89 64 41 75"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"62,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Association Serre la Coste Patrimoine et Environnement"","""",""Christine"",""GONTIER"",""3 rue du Levant"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061400000000"",""4.644470000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 39 37 40"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"63,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Associations Nouvelles Expressions"","""",""Pierre"",""DARDAILLON"",""5 rue de Cinq Sols"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064700000000"",""4.653250000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 95 02 19 69"",""public"",""04 66 50 08 67"",""public"","""","""",""dardaillon@hotmail.com"",""public"","""","""","""","""","""","""",""https://nouvellesexpressions.wixsite.com/association"",""https://nouvellesexpressions.wixsite.com/association"",""public"","""","""","""","""","""","""""	
"64,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Ball-Trap Club St Victor la Coste"","""",""Marion"",""FRESPUECH"",""16 bis impasse de la Roquette"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.062800000000"",""4.655290000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 03 26 25 77"",""public"",""04 66 50 15 91"",""public"","""","""",""btc.stvictorlacoste@hotmail.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"65,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""BC ST VICTOR Basket"","""",""Agnès"",""ESTOURNEL"",""10 route des Côtes du Rhône"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.067200000000"",""4.659650000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 33 87 50 86"",""public"",""04 66 50 01 74"",""public"","""","""",""agnes.estournel@orange.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"66,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Boules La Placette"","""",""Jean-Luc"",""Binetruy"",""18 rue de l\'Eglise"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.059900000000"",""4.643170000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 99 80 18 61"",""public"","""","""","""","""",""binetruy.jeanluc@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"67,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Boxe française - CEZE SAVATE"","""",""Mathieu"",""VILLA"","""","""","""","""","""","""",""St Marcel de Careiret"","""",""30330"","""",""44.143200000000"",""4.487920000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 82 71 55 88"",""public"","""","""","""","""","""","""","""","""","""","""","""","""",""http://club.quomodo.com/cezesavate/accueil"",""http://club.quomodo.com/cezesavate"",""public"","""","""","""","""","""","""""	
"68,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Club de Gymnastique adultes et enfants"","""",""Karine"",""FABRE"",""19 impasse de la Roquette"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062800000000"",""4.655290000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 74 19 39 90"",""public"","""","""","""","""",""clubgymstvictor@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"69,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Comité des fêtes"","""",""Jérémy"",""VALLOT"",""11 Rue de Font Crotade"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064800000000"",""4.638450000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""comitedesfetes30290@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"70,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Compagnie des doubles rideaux"","""",""Sandrine"",""SOLER"",""18 rue de Darbousset"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064900000000"",""4.660750000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 72 82 18 59"",""public"",""04 66 39 29 65"",""public"","""","""",""sandrine.soler30@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"71,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Courir à St Victor"","""",""André-Jean"",""PACOT"",""1 route de Palus"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.065400000000"",""4.655230000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 10 44"",""public"","""","""","""","""","""","""","""","""","""","""",""http://courirasaintvictor.org/"",""http://courirasaintvictor.org"",""public"","""","""","""","""","""","""""	
"72,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""Ermitage de Mayran"","""",""Hervé"",""FARAUD"",""4 chemin des Cadinières"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.069100000000"",""4.657280000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 70 96 47 53"",""public"",""04 66 50 00 48"",""public"","""","""",""serre-biau@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"73,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""FC CANABIER"","""",""Mennato"",""GOGLIA"","""","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 48 16 88 09"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"74,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""KOBUDO"","""",""Hubert"",""DELACROIX"",""1 rue de la Combe"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062000000000"",""4.638840000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 89 99 96 11"",""public"",""04 66 50 39 32"",""public"","""","""",""delhub@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"75,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""L\'AIR DU TEMPS"","""",""Roger"",""MAZZOLENI"",""7 chemin des Aumignanes"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.642380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 79 49 98 48"",""public"",""04 66 50 08 76"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""Association de 90 adhérents, qui se retrouve tous les lundis après-midi de 14h00 à 17h00 au <strong>Chalet des Cigales</strong>, au programme:<li>belote</li>	<li>scrabble</li><li>rami</li><li>jeux divers</li><li>café</li><li>thé</li><li>boissons fraîches</li><li>petits gâteaux</li>. Nous organisons des voyages à la journée, des voyages de plusieurs jours."","""","""","""""	
"76,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""L\'ATELIER D\'ART TEXTILE"","""",""Susi"",""GIRAUDIN"",""2 rue de la Grande Terre"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.065500000000"",""4.643120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 26 80"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"77,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""LA TABLE EN EQUILIBRE"","""",""Sylvie"",""MONJON"",""2 rue Emile Zola"","""","""","""","""","""",""St Victor la Coste"","""",""30290"","""",""44.065000000000"",""4.650000000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 61 99 27 45"",""public"","""","""","""","""",""latableenequilibre@gmail.com"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"78,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""LE JUDO CLUB"","""",""Laurent"",""PAUL"","""","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 82 83 49 68"",""public"","""","""","""","""","""","""","""","""","""","""","""","""",""http://www.coloj30.fr/COLOJ30.html"",""http://www.coloj30.fr"",""public"","""","""","""","""","""","""""	
"79,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""LIS ACABAIRE"","""",""Elisabeth"",""FARAUD"",""4 chemin des Cadinières"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.069100000000"",""4.657280000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""07 89 86 89 23"",""public"",""04 66 50 00 48"",""public"","""","""",""serre-biau@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"80,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""MUSIQUE A DO MI SI\'L"","""",""Marylise"",""BERTHEZENE"",""8 rue de Pépelin"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.060800000000"",""4.645740000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 22 26 16 06"",""public"",""04 66 50 20 94"",""public"","""","""",""musiqueadomisil@laposte.net"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"81,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""SOCIETE DE CHASSE"","""",""Mario"",""MERCADIER"",""3 Rue de la Roquette"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061900000000"",""4.654740000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 12 58"",""public"","""","""",""mario.mercadier@free.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"82,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""ST VICTOR SOLIDARITE"","""",""Jackie"",""LINDER"","""","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 15 64 91 65"",""public"","""","""","""","""",""plinder@wanadoo.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"83,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""TENNIS-CLUB"","""",""Philippe"",""RICARD"",""1 rue des chênes"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.067800000000"",""4.659940000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 70 95 75 40"",""public"","""","""","""","""",""p.ricard485@laposte.net"",""public"","""","""","""","""","""","""",""https://ballejaune.com/club/tcsaintvictorlacoste"",""https://ballejaune.com/club/tcsaintvictorlacoste"",""public"","""","""","""","""","""","""""	
"84,""0"",""organization"",""public"",""Associations"","""","""","""","""","""","""","""",""YOGA SOURCE"","""",""Jacqueline"",""CANNAUD"",""Le Grand Treillas"","""","""","""","""","""",""Gaujac"","""",""30303"","""",""44.080100000000"",""4.574810000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 39 21 60"",""public"","""","""",""delmh@wanadoo.fr"",""public"","""","""","""","""","""","""",""https://coeurduyogasud.fr/"",""https://coeurduyogasud.fr"",""public"","""","""","""","""","""","""""	
"85,""0"",""organization"",""public"",""Services,Immobilier"","""","""","""","""","""","""","""",""Francillon Bruno"",""Agent immobilier"","""","""",""11 rue du Puits de Laudun"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.064700000000"",""4.641380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 60 72 43 86"",""public"","""","""",""b.francillon@groupementimmo.net"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"86,""0"",""individual"",""public"",""Services,Immobilier"","""","""",""Laurent"","""",""ZERBIB"","""",""Auto-entrepreneur Immobilier"","""","""","""","""",""20 Rue du puits de Laudun"","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.064700000000"",""4.641380000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 10 79 95 27"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"87,""0"",""individual"",""public"",""Services,Immobilier"","""","""",""Virginie"","""",""Blanc"","""",""Conseillère en Immobilier"","""","""","""","""","""","""","""","""","""","""",""Saint Victor La Coste"","""",""30290"","""",""44.061800000000"",""4.642360000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 42 41 23 45"",""public"",""virginie.giraud@iadfrance.fr"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"88,""0"",""organization"",""public"",""Services,Aménagement paysager, entretien"","""","""","""","""","""","""","""",""FURMAR"","""","""","""",""Rue plaineautier"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.062200000000"",""4.640120000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 82 52 20"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""""	
"89,""0"",""organization"",""public"",""Services,DJ Animations, Evènements, Mariages"","""","""","""","""","""","""","""",""Concept Music Show by David"","""","""","""",""55 route de Saint Laurent des Arbres"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.063000000000"",""4.649790000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""06 88 06 72 25"",""public"","""","""","""","""","""","""","""","""",""http://www.dj30.fr/"",""dj30.fr"",""public"","""","""","""","""","""","""""	
"90,""0"",""organization"",""public"",""Services,Garage"","""","""","""","""","""","""","""",""Garage Davanier"","""","""","""",""20 rue de Cannes"","""","""","""","""","""",""Saint Victor la Coste"","""",""30290"","""",""44.065000000000"",""4.649130000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 66 50 36 85"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""""	
'
      ;
      
      
      
      $titre = '"Entry ID,""Order"",""Entry Type"",""Visibility"",""Categories"",""Family Name"",""Honorific Prefix"",""First Name"",""Middle Name"",""Last Name"",""Honorific Suffix"",""Title"",""Organization"",""Department"",""Contact First Name"",""Contact Last Name"",""Domicile Address | Line One"",""Domicile Address | Line Two"",""Domicile Address | Line Three"",""Domicile Address | Line Four"",""Domicile Address | District"",""Domicile Address | County"",""Domicile Address | City"",""Domicile Address | State"",""Domicile Address | Zipcode"",""Domicile Address | Country"",""Domicile Address | Latitude"",""Domicile Address | Longitude"",""Domicile Address | Visibility"",""Travail Address | Line One"",""Travail Address | Line Two"",""Travail Address | Line Three"",""Travail Address | Line Four"",""Travail Address | District"",""Travail Address | County"",""Travail Address | City"",""Travail Address | State"",""Travail Address | Zipcode"",""Travail Address | Country"",""Travail Address | Latitude"",""Travail Address | Longitude"",""Travail Address | Visibility"",""Phone | Téléphone mobile | Number"",""Phone | Téléphone mobile | Visibility"",""Phone | Téléphone maison | Number"",""Phone | Téléphone maison | Visibility"",""Phone | Téléphone professionnel | Number"",""Phone | Téléphone professionnel | Visibility"",""Email | Courriel personnel | Address"",""Email | Courriel personnel | Visibility"",""Email | Courriel professionnel | Address"",""Email | Courriel professionnel | Visibility"",""Social Network | Facebook | URL"",""Social Network | Facebook | Visibility"",""Im Uid"",""Im Visibility"",""Link | Site internet | URL"",""Link | Site internet | Title"",""Link | Site internet | Visibility"",""Dates Date"",""Dates Visibility"",""Biography"",""Notes"",""Photo URL"",""Logo URL"""	
      ';
      
    
      $tab_lignes = explode('""' ,$ligne);
      $tab_titres = explode(',' ,$titre);
      
    
   
   
   for($i=0 ; $i < sizeof($tab_lignes); $i++){
   
  
        // for($j=0 ; $j < sizeof($tab_lignes[$i]); $j++){
        
            if (($key = array_search(',', $tab_lignes)) !== false) {
                unset($tab_lignes[$key]);
            }
        // }
        
    }
    
    
    
    echo "<pre>";
    //   print_r($tab_titres);
      
    $tab_lignes =  array_chunk($tab_lignes, 65) ;
    
    print_r( array_chunk($tab_lignes, 65) );
    // dd($tab_lignes);
     
     $path = public_path("importlist.csv");
     
     $fp = fopen($path, 'w');
     
     fputcsv($fp, array("listing_title","listing_category","short_description","description","website","phone","email","listing_tags","address","code_postal","username","fee_id","expires_on"));
 

        foreach ($tab_lignes as $fields) {
            // dd($fields);
            
            if( sizeof($fields) < 64) continue;
            $newfield = array();
            for ($i=0; $i < sizeof($fields) ; $i++) { 
            
            
             //listing_title
                if($fields[2] == "organization"){
                
                    if($fields[12] != "" && $fields[14] != "" && $fields[15] != ""   ){
                    
                        $newfield[0] = $fields[12]." - ".$fields[14]." ".$fields[15] ; 
                        
                    
                    }elseif($fields[12] != "" && ($fields[14] == "" || $fields[15] == "") ){
                    
                        $newfield[0] = $fields[12]; 
                    
                    }elseif($fields[12] == "" && ($fields[14] != "" || $fields[15] != "")){
                    
                        $newfield[0] = $fields[14]." ".$fields[15] ; 
                        
                    }else{
                        $newfield[0] = "-";
                    }
                    
                    
                }else{
                    if($fields[7] != "" || $fields[9] != ""){
                    
                        if($fields[11] != ""){
                            $newfield[0] =  $fields[11].' - '. $fields[7]." ".$fields[9] ; 
                        
                        }else{
                        
                            $newfield[0] =  $fields[12].' - '. $fields[7]." ".$fields[9] ; 
                        }
                        
                    }else{
                        $newfield[0] = "-";
                    }
                
                }
            
                //    $newfield[0] = $fields[12] != ""  ? $fields[12]." - ".$fields[14]." ".$fields[15] : $fields[14]." ".$fields[15] ; 
                   
                   
                   $newfield[1] = $fields[4];  //listing_category
                   $newfield[2] = "";  //short_description
                   $newfield[3] = $fields[13].'. '. $fields[61];  //description
                   $newfield[4] = $fields[56];  //website
                   
                   
                   $newfield[5] = $fields[42];  // 42 ou 44 ou 46 phone
                   
                   $slash = $newfield[5] != "" ? " / " : "";
                   
                   
                   $newfield[5] .= $slash.$fields[44];
                   
                   $slash = $newfield[5] != "" ? " / " : "";
                  
                   $newfield[5] .= $slash.$fields[46];
                  
                   
                   $newfield[5] = str_replace('/  /', '/', $newfield[5]);
                   
                   if(substr($newfield[5],-2) == "/ "){
                    $newfield[5] = substr( $newfield[5], 0, -2);
                   }
                   echo $newfield[5] ."<br>";
               
                   
                    //48 ou 50 email
                   if($fields[50] != "" ){
                        $newfield[6] = $fields[50]; 
                   }elseif($fields[48] != "" ){
                        $newfield[6] = $fields[48] ; 
                   }else{
                   
                        $newfield[6] =  "toto@gmail.com"; 
                   }
                   
                   $newfield[7] = "";  //listing_tags
                   
                   if($fields[29] != "" || $fields[37] != "" || $fields[35] != ""   ){
                        $newfield[8] = $fields[29].', '. $fields[37].', '. $fields[35]; // Ou 16 24 22  //address
                   
                   }else{
                   
                        $newfield[8] = $fields[16].', '. $fields[24].', '. $fields[22]; // Ou 16 24 22  //address
                   
                   }
                   
                //    $newfield[8] = $fields[29].', '. $fields[37].', '. $fields[35]; // Ou 16 24 22  //address
                   
                   
                   $newfield[9] = "";  //code_postal
                   $newfield[10] ="stvictor2";  //username
                   $newfield[11] = "";  //fee_id
                   $newfield[12] = "";  //expires_on
            }
            
            // if($fields[29] == "4 Bis chemin du chardonay")
            // dd($newfield);
            // dd($newfield);
            fputcsv($fp, $newfield);
        }
        
    fclose($fp);
        
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function show(Tva $tva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function edit(Tva $tva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tva $tva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tva $tva)
    {
        //
    }
}
