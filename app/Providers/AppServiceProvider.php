<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Parametre;
use App\Compromis;
use App\Contrat;
use App\Filleul;
use App\Facture;
use App\User;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // $parametre = Parametre::first();
        // Config::set('setting.raison_sociale',$parametre->raison_sociale);
        // Config::set('setting.numero_siret',$parametre->numero_siret);
        // Config::set('setting.numero_rcs',$parametre->numero_rcs);
        // Config::set('setting.numero_tva',$parametre->numero_tva);
        // Config::set('setting.adresse',$parametre->adresse);
        // Config::set('setting.ville',$parametre->ville);
        // Config::set('setting.ca_imposable',$parametre->ca_imposable);
        // Config::set('setting.tva',$parametre->tva->tva_actuelle);
         


        //         // Dans cette partie on détermine le jour exaxt de il y'a 12 mois
        //         $today = date("Y-m-d");//  aujourd'hui 
        //         $date = strtotime( date("Y-m-d", strtotime($today)) . " -1 year");    // aujourd'hui  - 1 ans   
        
        //         $date_12 = date("Y-m-d",$date);
        

        
        
        
        
        //     //   ############ Chiffre d'affaire global / mois sur année civile  n et n-1 ##########
            
        //      // on determine les anneés n et n-1
        //     $annee_n = date('Y');
        //     $annee_n_1 = $annee_n-1;
        
        
        //     $CA_N = array();
        //         $ca_global_N = array();
        //         $ca_attente_N = array();
        //         $ca_encaisse_N = array();
        //         $ca_previsionel_N = array();
        //     $CA_N_1 = array();
        //         $ca_global_N_1 = array();
        //         $ca_attente_N_1 = array();
        //         $ca_encaisse_N_1 = array();
        //         $ca_previsionel_N_1 = array();
        
        //     //  ######## Sur l'année N ##########
        //     for ($i=1; $i <= 12 ; $i++) {                
                       
        //         $i < 10 ? $month = "0$i" : $month = $i;
               
        //         $ca_glo_n = Compromis::where('date_vente','like',"%$annee_n-$month%")->sum('frais_agence');
        //         $ca_global_N [] = $ca_glo_n;
        
        
        //         $compros_styls = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture',2]])->get();
        
        //         #####ca non encaissé, en attente de payement
        //         // on parcour les facture stylimmo non encaissée pour réccupérer les montant_ht  
        //         $ca_att_n = 0;
        //         if($compros_styls != null){
        //             foreach ($compros_styls as $compros_styl) {
        //                 if($compros_styl->getFactureStylimmo()->encaissee == 0){
        //                     $ca_att_n +=  $compros_styl->frais_agence ;
        //                 }
        //             }
        //         }
        //         $ca_attente_N [] = $ca_att_n;
        
        //         #####ca encaissé
        //         // on parcour les facture stylimmo  encaissée pour réccupérer les montant_ht  
        //         $ca_encai_n = 0;
        //         if($compros_styls != null){
        //             foreach ($compros_styls as $compros_styl) {
        //                 if($compros_styl->getFactureStylimmo()->encaissee == 1){
        //                     $ca_encai_n +=  $compros_styl->frais_agence ;
        //                 }
        //             }
        //         }
        
        //         // $ca_encai_n = Facture::where([['type','stylimmo'],['date_facture','like',"%$annee_n-$month%"],["encaissee",1]])->sum('montant_ht');
        //         $ca_encaisse_N [] = $ca_encai_n;
                
        //         $ca_previ_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture','<',2]])->sum('frais_agence');
        //         $ca_previsionel_N [] = $ca_previ_n;

        //     }

        //     //  ######## Sur l'année N-1 ##########
        //     for ($i=1; $i <= 12 ; $i++) {                
                       
        //         $i < 10 ? $month = "0$i" : $month = $i;
               
        //         $ca_glo_n_1 = Compromis::where('date_vente','like',"%$annee_n_1-$month%")->sum('frais_agence');
        //         $ca_global_N_1 [] = $ca_glo_n_1;
        
        
        //         $compros_styls_n_1 = Compromis::where([['date_vente','like',"%$annee_n_1-$month%"],['demande_facture',2]])->get();
        
        //         #####ca non encaissé, en attente de payement
        //         // on parcour les facture stylimmo non encaissée pour réccupérer les montant_ht  
        //         $ca_att_n_1 = 0;
        //         if($compros_styls_n_1 != null){
        //             foreach ($compros_styls_n_1 as $compros_styl) {
        //                 if($compros_styl->getFactureStylimmo()->encaissee == 0){
        //                     $ca_att_n_1 +=  $compros_styl->frais_agence ;
        //                 }
        //             }
        //         }
        //         $ca_attente_N_1 [] = $ca_att_n_1;
        
        //         #####ca encaissé
        //         // on parcour les facture stylimmo  encaissée pour réccupérer les montant_ht  
        //         $ca_encai_n_1 = 0;
        //         if($compros_styls_n_1 != null){
        //             foreach ($compros_styls_n_1 as $compros_styl) {
        //                 if($compros_styl->getFactureStylimmo()->encaissee == 1){
        //                     $ca_encai_n_1 +=  $compros_styl->frais_agence ;
        //                 }
        //             }
        //         }
        
        //         // $ca_encai_n = Facture::where([['type','stylimmo'],['date_facture','like',"%$annee_n-$month%"],["encaissee",1]])->sum('montant_ht');
        //         $ca_encaisse_N_1 [] = $ca_encai_n_1;
                
        //         $ca_previ_n_1 = Compromis::where([['date_vente','like',"%$annee_n_1-$month%"],['demande_facture','<',2]])->sum('frais_agence');
        //         $ca_previsionel_N_1 [] = $ca_previ_n_1;

        //     }




        // // dd($ca_global_N);
        
        //     $CA_N[] = $ca_global_N; 
        //     $CA_N[] = $ca_attente_N; 
        //     $CA_N[] = $ca_encaisse_N; 
        //     $CA_N[] = $ca_previsionel_N; 

        //     $CA_N_1[] = $ca_global_N_1; 
        //     $CA_N_1[] = $ca_attente_N_1; 
        //     $CA_N_1[] = $ca_encaisse_N_1; 
        //     $CA_N_1[] = $ca_previsionel_N_1; 
            
        //     // dd($CA_N);
        //     // $a_date = "2011-02";  
        //     // dd (date("Y-m-t", strtotime($a_date)));
        //     // dd(date("Y"));
        

        //     $STATS = array();
        //     $nb_affaires = Compromis::count();
        //     $nb_mandataires = User::where('role','mandataire')->count();
        //     $nb_filleuls = Filleul::count();
        
        
        //     $STATS["nb_affaires"] = $nb_affaires;
        //     $STATS["nb_mandataires"] = $nb_mandataires;
        //     $STATS["nb_filleuls"] = $nb_filleuls;



        //     Config::set('stats.CA_N',$CA_N);
        //     Config::set('stats.CA_N_1',$CA_N_1);
        //     Config::set('stats.STATS',$STATS);
            



    }
}
