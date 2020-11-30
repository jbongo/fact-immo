<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compromis;
use App\User;
use App\Filleul;
use App\Parametre;
use App\Contrat;
use App\Facture;
use Auth;
use Config;
use App\Tva;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( $annee = null)
    {
    //     ############ Infos de stats ##########



                // Dans cette partie on détermine le jour exaxt de il y'a 12 mois
                $today = date("Y-m-d");//  aujourd'hui 
                $date = strtotime( $today. " -1 year");    // aujourd'hui  - 1 ans   
        
                $date_12 = date("Y-m-d",$date);
        

        
        
        
        
            //   ############ Chiffre d'affaire global / mois sur année civile  n et n-1 ##########
            
            $annee = intval($annee);
           
             // on determine les anneés n et n-1
            if( is_int($annee) && $annee >= 2017){
                $annee_n = $annee;
            }else{
                $annee_n = date('Y');
            }
            
            $annee_n_1 = $annee_n-1;
        
        
            $CA_N = array();
                $ca_global_N = array();
                $ca_attente_N = array();
                $ca_encaisse_N = array();
                $ca_sous_offre_N = array();
                $ca_sous_compromis_N = array();
            $CA_N_1 = array();
                $ca_global_N_1 = array();
                $ca_attente_N_1 = array();
                $ca_encaisse_N_1 = array();
                $ca_sous_offre_N_1 = array();
                $ca_sous_compromis_N_1 = array();

                $nb_global_N = 0;
                $nb_sous_offre_N = 0;
                $nb_sous_compromis_N = 0;
                $nb_en_attente_N = 0;
                $nb_encaisse_N = 0;

     if(Auth::user()->role == "admin"){
            //  ######## Sur l'année N ##########
            for ($i=1; $i <= 12 ; $i++) {                
                       
                $i < 10 ? $month = "0$i" : $month = $i;
               
               
        
        
                // $compros_styls = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture',2],['archive',false]])->get();
        
                #####ca non encaissé, en attente de payement


                //  on réccupère toutes les factures stylimmo du mois en cour qui n'ont pas encore été encaissée 
                $ca_att_n = Facture::where([['type','stylimmo'],['encaissee',0],['date_facture','like',"%$annee_n-$month%"]])->sum('montant_ht');
                $nb_en_attente_n = Facture::where([['type','stylimmo'],['encaissee',0],['date_facture','like',"%$annee_n-$month%"]])->count();
                $nb_en_attente_N += $nb_en_attente_n ;


                
                // on parcour les facture stylimmo non encaissée pour réccupérer les montant_ht  
                // $ca_att_n = 0;
                // if($compros_styls != null){
                //     foreach ($compros_styls as $compros_styl) {
                //         if($compros_styl->getFactureStylimmo()->encaissee == 0){
                //             $ca_att_n +=  $compros_styl->frais_agence ;
                //             $nb_en_attente_N++;
                //         }
                //     }
                // }
                $ca_attente_N [] = round($ca_att_n/Tva::coefficient_tva(),2);
        
                #####ca encaissé
                //  on réccupère toutes les factures stylimmo encaissées au cours du mois
                $ca_encai_n = Facture::where([['type','stylimmo'],['encaissee',1],['date_encaissement','like',"%$annee_n-$month%"]])->sum('montant_ht');
                $nb_encaisse_n  = Facture::where([['type','stylimmo'],['encaissee',1],['date_encaissement','like',"%$annee_n-$month%"]])->count();
                $nb_encaisse_N += $nb_encaisse_n;

                // dd($ca_encai_n);





                // on parcour les facture stylimmo  encaissée pour réccupérer les montant_ht  
                // $ca_encai_n = 0;
                // if($compros_styls != null){
                //     foreach ($compros_styls as $compros_styl) {
                //         if($compros_styl->getFactureStylimmo()->encaissee == 1){
                //             $ca_encai_n +=  $compros_styl->frais_agence ;
                //             $nb_encaisse_N++;
                //         }
                //     }
                // }
        
                // $ca_encai_n = Facture::where([['type','stylimmo'],['date_facture','like',"%$annee_n-$month%"],["encaissee",1]])->sum('montant_ht');
                $ca_encaisse_N [] = round($ca_encai_n/Tva::coefficient_tva(),2);
                
                $ca_sous_offre_n = Compromis::where([['created_at','like',"%$annee_n-$month%"],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->sum('frais_agence');
                $nb_sous_offre_n = Compromis::where([['created_at','like',"%$annee_n-$month%"],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();
                $nb_sous_offre_N +=  $nb_sous_offre_n;
                
                $ca_sous_offre_N [] = round($ca_sous_offre_n/Tva::coefficient_tva(),2);

                $ca_sous_compromis_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->sum('frais_agence');
                $nb_sous_compromis_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->count();
                $nb_sous_compromis_N += $nb_sous_compromis_n ;
                
                $ca_sous_compromis_N [] = round($ca_sous_compromis_n/Tva::coefficient_tva(),2);


                $ca_glo_n = $ca_encai_n + $ca_att_n + $ca_sous_offre_n + $ca_sous_compromis_n;

                $nb_global_N += ( $nb_encaisse_n + $nb_en_attente_n + $nb_sous_compromis_n + $nb_sous_offre_n);       
                $ca_global_N [] = round($ca_glo_n/Tva::coefficient_tva(),2);
               
                // $ca_glo_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['archive',false]])->sum('frais_agence');
                // $nb_global_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['archive',false]])->count();
                // $ca_global_N [] = round($ca_glo_n/Tva::coefficient_tva(),2);

            }

         } 
        else{

           
            // CALCUL DES CA POUR LES MANDATAIRES
            $nb_global_N = 0;
            $nb_sous_offre_n = 0;
            $nb_sous_offre_N = 0;
            $nb_sous_compromis_n = 0;
            $nb_sous_compromis_N = 0;
            $nb_en_attente_n = 0;
            $nb_en_attente_N = 0;
            $nb_encaisse_n = 0;
            $nb_encaisse_N = 0;
           
            //  ######## Sur l'année N ##########
            for ($i=1; $i <= 12 ; $i++) {                
                                
                $i < 10 ? $month = "0$i" : $month = $i;
            
                // // CA Global non partagé
                // $ca_glo_partage_pas_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['archive',false]])->sum('frais_agence');
                // $nb_global_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['archive',false]])->count();
                
                // // CA Global partagé et porte affaire
                // $ca_glo_porte_n = 0;
                // $compro_glo_porte_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['archive',false]])->get();
                // $nb_global_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['archive',false]])->count();
                // $nb_global_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['archive',false]])->count();
                
                // foreach ($compro_glo_porte_n as $compro) {
                //     $ca_glo_porte_n += $compro->frais_agence * $compro->pourcentage_agent/100 ;
                // }

                // // CA Global partagé et ne porte pas affaire
                // $ca_glo_porte_pas_n = 0;
                // $compro_glo_porte_pas_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['archive',false]])->get();
                
                // foreach ($compro_glo_porte_pas_n as $compro) {
                //     $ca_glo_porte_pas_n += $compro->frais_agence * (100-$compro->pourcentage_agent)/100 ;
                // }
                
                // $ca_global_N [] = round(($ca_glo_partage_pas_n+$ca_glo_porte_n+$ca_glo_porte_pas_n)/Tva::coefficient_tva(),2);



                #####ca non encaissé, en attente de payement
                $compros_styls = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture',2],['archive',false]])->get();
                // on parcour les facture stylimmo non encaissée pour réccupérer les montant_ht  
               

                // $ca_att_n = 0;
                // if($compros_styls != null){
                //     foreach ($compros_styls as $compros_styl) {
                //         if($compros_styl->getFactureStylimmo()->encaissee == 0){
                //             $ca_att_n +=  $compros_styl->frais_agence ;
                //         }
                //     }
                // }
          

                                // CA en attente non partagé
                                $compro_attente_partage_pas_n = Compromis::where([['user_id',Auth::id()],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
                                    $ca_attente_partage_pas_n = 0;
                                    if($compro_attente_partage_pas_n != null){
                                        // dd("dd");
                                        foreach ($compro_attente_partage_pas_n as $compros_att) {
                                            if($compros_att->getFactureStylimmo()->encaissee == 0 && $compros_att->getFactureStylimmo()->date_facture->format('m-Y') == "$month-$annee_n"){
                                                $ca_attente_partage_pas_n +=  $compros_att->frais_agence ;
                                                $nb_en_attente_n++;                                             
                                                $nb_en_attente_N++;                                             
                                            }
                                        }
                                    }


                                // CA en attente partagé et porte affaire
                                $compro_attente_porte_n = Compromis::where([['user_id',Auth::id()],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
                                $ca_attente_porte_n = 0;

                                    if($compro_attente_porte_n != null){
                                        foreach ($compro_attente_porte_n as $compros_att) {
                                            if($compros_att->getFactureStylimmo()->encaissee == 0 && $compros_att->getFactureStylimmo()->date_facture->format('m-Y') == "$month-$annee_n"){
                                                $ca_attente_porte_n +=  $compros_att->frais_agence * $compros_att->pourcentage_agent/100;
                                                $nb_en_attente_n++;
                                                $nb_en_attente_N++;
                                                // dd("$month-$annee");
                                                
                                            }
                                        }
                                    }

                
                                // CA en attente partagé et ne porte pas affaire
                     
                                $compro_attente_porte_pas_n = Compromis::where([['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
                                $ca_attente_porte_pas_n = 0;

                                    if($compro_attente_porte_pas_n != null){
                                        foreach ($compro_attente_porte_pas_n as $compros_att) {
                                            if($compros_att->getFactureStylimmo()->encaissee == 0 && $compros_att->getFactureStylimmo()->date_facture->format('m-Y') == "$month-$annee_n"){
                                                $ca_attente_porte_pas_n +=  $compros_att->frais_agence * (100-$compros_att->pourcentage_agent)/100;
                                                $nb_en_attente_n++;
                                                $nb_en_attente_N++;
                                                // dd($nb_en_attente_N);
                                               
                                            }
                                        }
                                    }

                                    // dd($nb_en_attente_N);
                             
                                
                                $ca_attente_n = round(($ca_attente_partage_pas_n+$ca_attente_porte_n+$ca_attente_porte_pas_n)/Tva::coefficient_tva(),2);
                                $ca_attente_N [] = $ca_attente_n;

                                    // dd($ca_attente_N);

                                #####ca encaissé

                                // CA encaissé non partagé

                                $compro_encaisse_partage_pas_n = Compromis::where([['user_id',Auth::id()],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
                                $ca_encaisse_partage_pas_n = 0;
                                if($compro_encaisse_partage_pas_n != null){
                                    foreach ($compro_encaisse_partage_pas_n as $compros_encaisse) {
                                        if($compros_encaisse->getFactureStylimmo()->encaissee == 1  && $compros_encaisse->getFactureStylimmo()->date_encaissement->format('m-Y') == "$month-$annee_n"){
                                            $ca_encaisse_partage_pas_n +=  $compros_encaisse->frais_agence ;
                                            $nb_encaisse_n++;
                                            $nb_encaisse_N++;
                                        }
                                    }
                                }
                               
                            

                                // CA encaissé partagé et porte affaire
                                $compro_encaisse_porte_n = Compromis::where([['user_id',Auth::id()],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
                                $ca_encaisse_porte_n = 0;

                                    if($compro_encaisse_porte_n != null){
                                        foreach ($compro_encaisse_porte_n as $compros_encaisse) {
                                            if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format('m-Y') == "$month-$annee_n"){
                                                $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                                                $nb_encaisse_n++;
                                                $nb_encaisse_N++;
                                            }
                                        }
                                    }

                
                                // CA encaissé partagé et ne porte pas affaire
                     
                                $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
                                $ca_encaisse_porte_pas_n = 0;

                                    if($compro_encaisse_porte_pas_n != null){
                                        foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                                            if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format('m-Y') == "$month-$annee_n"){
                                                $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                                                $nb_encaisse_n++;
                                                $nb_encaisse_N++;
                                            }
                                        }
                                    }

                             
                                
                                $ca_encaisse_n = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/Tva::coefficient_tva(),2);
                                $ca_encaisse_N [] = $ca_encaisse_n;
                                

                            // CA SOUS OFFRE
                           

                            // CA Sous offre non partagé
                            $ca_offre_partage_pas_n = Compromis::where([['created_at','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->sum('frais_agence');
                            $nb_sous_offre_n += Compromis::where([['created_at','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();
                            $nb_sous_offre_N += Compromis::where([['created_at','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();

                            // CA Sous offre partagé et porte affaire
                            $ca_offre_porte_n = 0;
                            $compro_offre_porte_n = Compromis::where([['created_at','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->get();
                            $nb_sous_offre_n += Compromis::where([['created_at','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();
                            $nb_sous_offre_N += Compromis::where([['created_at','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();
                            
                            foreach ($compro_offre_porte_n as $compro) {
                                $ca_offre_porte_n += $compro->frais_agence * $compro->pourcentage_agent/100 ;
                            }

                            // CA Sous offre partagé et ne porte pas affaire
                            $ca_offre_porte_pas_n = 0;
                            $compro_offre_porte_pas_n = Compromis::where([['created_at','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->get();
                            $nb_sous_offre_n += Compromis::where([['created_at','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();
                            $nb_sous_offre_N += Compromis::where([['created_at','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->count();
                            
                            foreach ($compro_offre_porte_pas_n as $compro) {
                                $ca_offre_porte_pas_n += $compro->frais_agence * (100-$compro->pourcentage_agent)/100 ;
                            }
                            
                            $ca_sous_offre_n = round(($ca_offre_partage_pas_n+$ca_offre_porte_n+$ca_offre_porte_pas_n)/Tva::coefficient_tva(),2);
                            $ca_sous_offre_N [] = $ca_sous_offre_n;





                            // CA SOUS COMPROMIS


                           

                            // CA Sous compromis non partagé
                            $ca_compromis_partage_pas_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->sum('frais_agence');
                            $nb_sous_compromis_n += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->count();
                            $nb_sous_compromis_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',false],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->count();
                           

                            // CA Sous compromis partagé et porte affaire
                            $ca_compromis_porte_n = 0;
                            $compro_compromis_porte_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->get();
                            $nb_sous_compromis_n += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->count();
                            $nb_sous_compromis_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['user_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->count();
                            
                            foreach ($compro_compromis_porte_n as $compro) {
                                $ca_compromis_porte_n += $compro->frais_agence * $compro->pourcentage_agent/100 ;
                            }

                            // CA Sous compromis partagé et ne porte pas affaire
                            $ca_compromis_porte_pas_n = 0;
                            $compro_compromis_porte_pas_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->get();
                            $nb_sous_compromis_n += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->count();
                            $nb_sous_compromis_N += Compromis::where([['date_vente','like',"%$annee_n-$month%"],['agent_id',Auth::id()],['est_partage_agent',true],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['archive',false],['archive',false]])->count();
                            
                            foreach ($compro_compromis_porte_pas_n as $compro) {
                                $ca_compromis_porte_pas_n += $compro->frais_agence * (100-$compro->pourcentage_agent)/100 ;
                            }
                            
                            $ca_sous_compromis_n = round(($ca_compromis_partage_pas_n+$ca_compromis_porte_n+$ca_compromis_porte_pas_n)/Tva::coefficient_tva(),2);
                            $ca_sous_compromis_N [] = $ca_sous_compromis_n;

                           
                            // CA GLOBAL 
                            $ca_glo_n = $ca_encaisse_n + $ca_attente_n + $ca_sous_offre_n + $ca_sous_compromis_n;
                            $ca_global_N [] = round($ca_glo_n,2);

                            $nb_global_N += ( $nb_encaisse_n + $nb_en_attente_n + $nb_sous_compromis_n + $nb_sous_offre_n);       

                            // on rénitiale les valeurs 
                            $nb_sous_compromis_n = 0;
                            $nb_encaisse_n = 0;
                            $nb_en_attente_n = 0;
                            $nb_sous_offre_n = 0;

            }



}


        // dd($ca_global_N);
        
            $CA_N[] = $ca_global_N; 
            $CA_N[] = $ca_attente_N; 
            $CA_N[] = $ca_encaisse_N; 
            $CA_N[] = $ca_sous_offre_N; 
            $CA_N[] = $ca_sous_compromis_N; 

            $STATS = array();
            $nb_affaires = Compromis::count();
            $nb_mandataires = User::where('role','mandataire')->count();
            $nb_filleuls = Filleul::where('expire',0)->count();
      
        
            $STATS["nb_affaires"] = $nb_affaires;
            $STATS["nb_global_N"] = $nb_global_N;
            $STATS["nb_sous_offre_N"] = $nb_sous_offre_N;
            $STATS["nb_sous_compromis_N"] = $nb_sous_compromis_N;
            $STATS["nb_en_attente_N"] = $nb_en_attente_N;
            $STATS["nb_encaisse_N"] = $nb_encaisse_N;
            $STATS["annee"] = $annee_n;
        
            $STATS["nb_mandataires"] = $nb_mandataires;
            $STATS["nb_filleuls"] = $nb_filleuls;

           
            Config::set('stats.CA_N',$CA_N);
            Config::set('stats.STATS',$STATS);
            
            //  dd( $STATS);




        return view('home');
    }
    
}
