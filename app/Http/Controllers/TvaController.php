<?php

namespace App\Http\Controllers;

use App\Tva;
use App\Mail\EncaissementFacture;
use App\Facture;
use Mail;
use Illuminate\Http\Request;

class TvaController extends Controller
{
    /**
     * tests
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {

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
      "23,""0"",""organization"",""public"",""Commerces"","""","""","""","""","""","""","""",""Vival"","""",""Mr"",""et Mme GILLES"",""Place de la Mairie"","""","""","""","""","""",""St Victor la Coste"","""",""30290"","""",""44.060900000000"",""4.641030000000"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""","""",""04 34 47 01 74"",""public"","""","""","""","""","""","""","""","""","""","""","""","""","""","" ""	'
        
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
    
    // dd($tab_lignes);
    //  print_r( array_chunk($tab_lignes, 65) );
     
     $path = public_path("importlist.csv");
     
     $fp = fopen($path, 'w');
     
     fputcsv($fp, array("listing_title","listing_category","short_description","description","website","phone","email","listing_tags","address","code_postal","username","fee_id","expires_on"));
     
        foreach ($tab_lignes as $fields) {
            // dd($fields);
            $newfield = array();
            for ($i=0; $i < sizeof($fields) ; $i++) { 
            
               $newfield[0] = $fields[12] != ""  ? $fields[12]." - ".$fields[14]." ".$fields[15] : $fields[14]." ".$fields[15] ;  //listing_title
               $newfield[1] = $fields[4];  //listing_category
               $newfield[2] = "";  //short_description
               $newfield[3] = $fields[13].'. '. $fields[61];  //description
               $newfield[4] = $fields[56];  //website
               $newfield[5] = $fields[46];  //phone
               $newfield[6] = $fields[50] == "" ? "toto@gmail.com" : $fields[50];  //email
               $newfield[7] = "";  //listing_tags
               $newfield[8] = $fields[29].', '. $fields[37].', '. $fields[35];  //address
               $newfield[9] = "";  //code_postal
               $newfield[10] ="stvictor2";  //username
               $newfield[11] = "";  //fee_id
               $newfield[12] = "";  //expires_on
            }
            
            
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
