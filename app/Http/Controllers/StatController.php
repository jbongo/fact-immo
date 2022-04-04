<?php

namespace App\Http\Controllers;
use App\Compromis;
use App\User;
use App\Filleul;
use App\Parametre;
use App\Contrat;
use App\Facture;
use App\Packpub;
use App\Article;
use Auth;
use Config;
use App\Tva;


use Illuminate\Http\Request;

class StatController extends Controller
{
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
            
                
            $PUB_N = array();
            $PUB_VENDU = array();
            
            $PUB_ACH = 0 ; 
                
                
                
  /*****************
    ######              ADMIN        ######
*****************/


            //  ######## Sur l'année N ##########
            for ($i=1; $i <= 12 ; $i++) {                
                       
                $month = $i < 10 ? "0$i" : $i;
               
                       
          
                
                
                // ########## PUB #############
                
                
                for ($y=1; $y <= 12 ; $y++) { 
                    $month = $y < 10 ? "0$y" : $y;
                    
                    $montant_jeton = Facture::where([['nb_mois_deduis', '<>', null], ['date_deduction','like',"%$annee_n-$month%"]])->sum('montant_ttc_deduis');
                    $montant_pub = Facture::where([['type','pack_pub'], ['date_encaissement','like',"%$annee_n-$month%"]])->sum('montant_ttc');
                    
                    
                    
                   $PUB_N[$y] =  $montant_jeton + $montant_pub;
                   
                   
                   $vendu_y = Packpub::join('contrats', 'packpubs.id','contrats.packpub_id')
                   ->where([['contrats.a_demission',false], ['date_deb_activite', '<=',"$annee_n-$month-01"]])
               
                   ->sum('packpubs.tarif')
                // ->get()
                   ;
               
                   
                    $PUB_VENDU[$y] = $vendu_y;
                    
                }
                       
                
                // dd($PUB_VENDU);
               
                $PUB_ACH = Article::where([['type', 'annonce'], ['a_expire', false]])->sum('prix_achat');
                
            
               // ########### Autres chiffres

                //Nombre d'affaires en cours (Nombre d'affaires non cloturées)
                
                
                
            }
            
            
            
            
            // ########### Autres chiffres
            
            //Nombre d'affaires en cours (Nombre d'affaires non cloturées partagées ou non)
            $nb_affaires_en_cours = Compromis::where([['archive',false],['cloture_affaire','<',2]])->count();


        $STATS = array();


          
            ################## MOYENNE DES CHIFFRES D'AFFAIRES ########################## 
            
            $CA_MOY = array();
            $CA = array();
            
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-01%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-02%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 2 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-03%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 3 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-04%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 4 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-05%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 5 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-06%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 6 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-07%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 7 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-08%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 8 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-09%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 9 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-10%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 10 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-11%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 11 ;
            $CA [] =  Facture::where([['type','stylimmo'],['encaissee',1], ['a_avoir',0],['date_encaissement','like',"%$annee_n-12%"]])->sum('montant_ht');
            $CA_MOY [] = array_sum($CA) / 12 ;
            
            ################## AUTRE CALCULS ########################## 
            
        if(Auth::user()->role == "admin"){
            //    Nombre de mandataires actifs
            $nb_mandataires_actifs = Contrat::where([['est_fin_droit_suite',false], ['user_id', '<>', null]])->count();
            
            // Nb mandataire ayants saisis une affaire à l'année N
            $nb_mandataires_actifs_n = sizeof(Compromis::where('created_at','like',"%$annee_n%" )->select('user_id')->distinct()->get()->toArray() ); 
            
             //    Nombre de mandataires aux jetons
             $nb_mandataires_jetons = Contrat::where([['deduis_jeton',true], ['user_id', '<>', null],['est_fin_droit_suite',false]])->count();
            
            //    Nombre de mandataires à la facturation
            $nb_mandataires_facture_pub = Contrat::where([['est_soumis_fact_pub', true], ['deduis_jeton',false], ['user_id', '<>', null],['est_fin_droit_suite',false]])->count();
            
            // Nombre de filleuls actifs
            $nb_filleuls = Filleul::where('expire',0)->select('user_id')->distinct()->count();

            // Classement des mandataires
            
            $contrat_actifs = Contrat::where([['est_fin_droit_suite',false], ['user_id', '<>', null]])->get();
         
         
         
            // Classement sur l'année N
            $classements_n = array();
            foreach ($contrat_actifs as $cont) {
                $classements_n[] = [$cont->user->chiffre_affaire_styl("$annee_n-01-01", date("Y-m-d")), $cont->user ]  ;
             
            }
            // Trier dans l'ordre decroissant 
            rsort($classements_n );

            
            
             // Classement générale
             $classements = array();
             foreach ($contrat_actifs as $cont) {
                $classements[] = [$cont->user->chiffre_affaire_styl("2020-01-01", date("Y-m-d")), $cont->user ]  ;
              
             }
             // Trier dans l'ordre decroissant 
             rsort($classements );
             
             
             

            $STATS["nb_affaires_en_cours"] = $nb_affaires_en_cours;
            $STATS["nb_mandataires_actifs_n"] = $nb_mandataires_actifs_n;
            $STATS["nb_mandataires_actifs"] = $nb_mandataires_actifs;
            $STATS["nb_filleuls"] = $nb_filleuls;
            $STATS["nb_mandataires_jetons"] = $nb_mandataires_jetons;
            $STATS["nb_mandataires_facture_pub"] = $nb_mandataires_facture_pub;
            
            $STATS["classements"] = $classements;
            $STATS["classements_n"] = $classements_n;
               
            $STATS['TOTAL_PUB_N'] = array_sum($PUB_N)  ;
            $STATS['TOTAL_PUB_ACH'] = $PUB_ACH * 12 ;           
            $STATS['PUB_N'] = $PUB_N ;
            $STATS['PUB_ACH'] = $PUB_ACH ; 
            $STATS['PUB_VENDU'] = $PUB_VENDU ; 
            
        }    
            
            
            $STATS["annee"] = $annee_n;
            $STATS["CA_MOY"] = $CA_MOY;
            $STATS["CA"] = $CA;
            
            Config::set('stats.STATS',$STATS);
      
            
        
        return view('stats.index');
    }
}
