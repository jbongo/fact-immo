<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Facture;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded=[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function  contrat(){

        return $this->hasOne('App\Contrat');
    }

    public function  filleul(){

        return $this->hasOne('App\Filleul');
    }


    // Chiffre d'affaires encaissé par le mandataire compris entre date deb et date fin
    public function  chiffre_affaire($date_deb, $date_fin){
   
        $chiffre_affaire_encai = Facture::where([['user_id',$this->id],['reglee',true]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->whereBetween('date_reglement', [$date_deb, $date_fin])->sum('montant_ht');
        return $chiffre_affaire_encai; 
     
    }
    
    // Chiffre d'affaires non encaissé par le mandataire compris entre date deb et date fin
    public function  chiffre_affaire_non_encaisse($date_deb, $date_fin){
   
        $chiffre_affaire_non_encai = Facture::where([['user_id',$this->id],['reglee',false]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->whereBetween('created_at', [$date_deb, $date_fin])->sum('montant_ht');
        return $chiffre_affaire_non_encai; 
     
    }
    
    // nombre d'affaires encaissé par le mandataire compris entre date deb et date fin
    public function  nb_affaire_encaisse($date_deb, $date_fin){
   
        $chiffre_affaire_encai = Facture::where([['user_id',$this->id],['reglee',true]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->whereBetween('date_reglement', [$date_deb, $date_fin])->count();
        return $chiffre_affaire_encai; 
     
    }
    
    // nombre d'affaires non encaissé par le mandataire compris entre date deb et date fin
    public function  nb_affaire_non_encaisse($date_deb, $date_fin){
   
        $chiffre_affaire_non_encai = Facture::where([['user_id',$this->id],['reglee',false]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->whereBetween('created_at', [$date_deb, $date_fin])->count();
        return $chiffre_affaire_non_encai; 
     
    }

    // Chiffre d'affaire stylimmo encaissé compris entre date deb et date fin
        public function  chiffre_affaire_styl($date_deb, $date_fin){


            $compro_encaisse_partage_pas_n = Compromis::where([['user_id',$this->id],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_partage_pas_n = 0;
            if($compro_encaisse_partage_pas_n != null){                
                foreach ($compro_encaisse_partage_pas_n as $compros_encaisse) {
                    if($compros_encaisse->getFactureStylimmo() != null && $compros_encaisse->getFactureStylimmo()->a_avoir == false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                        $ca_encaisse_partage_pas_n +=  $compros_encaisse->getFactureStylimmo()->montant_ttc;
                    
                    }
               }
               
           }
        
            // CA encaissé partagé et porte affaire
            $compro_encaisse_porte_n = Compromis::where([['user_id',$this->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_n = 0;

                if($compro_encaisse_porte_n != null){
                    foreach ($compro_encaisse_porte_n as $compros_encaisse) {

                        if($compros_encaisse->getFactureStylimmo() != null && $compros_encaisse->getFactureStylimmo()->a_avoir == false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                        }
                    }
                }


            // CA encaissé partagé et ne porte pas affaire
 
            $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',$this->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_pas_n = 0;

                if($compro_encaisse_porte_pas_n != null){
                    foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                        if($compros_encaisse->getFactureStylimmo() != null && $compros_encaisse->getFactureStylimmo()->a_avoir == false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                        }
                    }
                }

         
            
            $ca_encaisse_N = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/Tva::coefficient_tva(),2);


        return $ca_encaisse_N ;    
         
        }



    // Chiffre d'affaire stylimmo encaissé lié aux affaires réglée compris entre date deb et date fin 
    public function  chiffre_affaire_styl_associe($date_deb, $date_fin){

        $factures_encaissees = Facture::where([['user_id',$this->id],['reglee',true]])->whereIn('type',['honoraire','partage'])->whereBetween('date_reglement', [$date_deb, $date_fin])->get();
        
        $ca_encaisse = 0 ;
        
        foreach ($factures_encaissees as $facture) {
            
            $compromis = $facture->compromis;
            
            // Si l'affaire n'est pas partagée
            if($compromis->est_partage_agent == false){
            
            
                $ca_encaisse += $compromis->getFactureStylimmo()->montant_ht;
            
            // }Si l'affaire est partagée
            }else{
                // Si le mandataire porte l'affaire
                if($compromis->user_id == $this->id){
                
                    $ca_encaisse += $compromis->getFactureStylimmo()->montant_ht * $compromis->pourcentage_agent/100;
                    
                } //Si le mandataire ne porte pas l'affaire
                else{
                    $ca_encaisse += $compromis->getFactureStylimmo()->montant_ht * (100 - $compromis->pourcentage_agent)/100 ;
                }
            
            }
            
        }
        

        return $ca_encaisse;    
     
    }




    // Calucl le nombre vente du mandataire, 

    public function  nombre_vente($date_deb, $date_fin){

        $compromis = Compromis::where('user_id',$this->id)->orWhere('agent_id', $this->id)->get();
        $nb_vente = 0 ;

        foreach ($compromis as $compro) {
           
            if($compro->getFactureStylimmo() != null){
                if($compro->getFactureStylimmo()->a_avoir == false && $compro->getFactureStylimmo()->encaissee == true   && $compro->getFactureStylimmo()->date_encaissement->format('Y-m-d') >= $date_deb &&   $compro->getFactureStylimmo()->date_encaissement->format('Y-m-d') <= $date_fin){
                    $nb_vente ++;
                }
            }
            
        }


        return $nb_vente; 
     
    }
    

    // Retourn le nombre de filleuls parrainné dans sur une période

    public function  nombre_filleul($date_deb, $date_fin){

        $filleuls = Filleul::where('parrain_id',$this->id)->get();
        $nb_filleul = 0 ;

        foreach ($filleuls as $filleul) {
           
            if($filleul->user->contrat->date_entree->format('Y-m-d') >= $date_deb && $filleul->user->contrat->date_entree->format('Y-m-d')  <= $date_fin ){
                $nb_filleul ++;
            } 
            
        }


        return $nb_filleul; 
     
    }


    public function  date_anniv($lang = "en"){

            // On va determiner la dernière date d'anniv de sa date d'anniversaire
           
            if($this->contrat == null){
                return null;
            }
            $m_entree = $this->contrat->date_deb_activite->format('m');
            $d_entree = $this->contrat->date_deb_activite->format('d');
            $m_d_entree = $this->contrat->date_deb_activite->format('m-d');
            

            $y_en_cour = date('Y');

            $today = date('Y-m-d');

            // Si aujourdhui > à la date anniv
                if($today > $y_en_cour.'-'.$m_d_entree  ){
                
                    if($lang == "en"){
                        $date_anniv = $y_en_cour.'-'.$m_d_entree ;
                    
                    }else{
                        $date_anniv = $d_entree.'/'.$m_entree.'/'.$y_en_cour ;
                    
                    }
                    
                }else{
                
                    if($lang == "en"){
                        $date_anniv =  ($y_en_cour-1).'-'.$m_d_entree ;
                    
                    }else{
                        $date_anniv = $d_entree.'/'.$m_entree.'/'.($y_en_cour-1) ;
                    
                    }
        
                }
                
               

            return $date_anniv; 
     
    }


     
    // Retourne le max à deduire et le reste à déduire
    public function etat_jeton(){
        
        $mandataire = User::where('id', $this->id)->first();
        $tab = array();
        
        if($mandataire->contrat->deduis_jeton == true) {
        
            $jeton_restant = $mandataire->nb_mois_pub_restant ;
            $tab["jeton_restant"] = $jeton_restant;
            
            $today = date_create(date('Y-m-d'));
            $date_anniv = date_create($mandataire->date_anniv());
            
            // nombre de mois entre la date d'anniv et aujourd'hui == nombre de jeton minimum à deduire pour être à jour
            $interval = date_diff($today, $date_anniv);
            
            // Nombre de jeton qui doit rester à deduire
            $nb_mois_max  = 12 - $interval->m;
            $tab["jeton_max"] = $nb_mois_max ;
            
            
            $tab["retard"] =  ($jeton_restant - $nb_mois_max) > 0 ? ($jeton_restant - $nb_mois_max) : 0 ;
            
            $tab["jeton_min_a_deduire"] = $tab["retard"] > 3 ?  $tab["retard"]  - 3 : 0 ;
            
            $tab['date_anniv'] = $mandataire->date_anniv("fr");
        
        }else{
            return null; 
        }
        
        
        return $tab;
    }
    
    
    // Retourne les infos prospect lorsque le mandataire étatit prospect
    public function prospect(){
    
        return $this->hasOne('App\Prospect');
    
    }

}
