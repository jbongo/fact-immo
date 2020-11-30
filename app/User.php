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


    // Chiffre d'affaire encaissé compris entre date deb et date fin
    public function  chiffre_affaire($date_deb, $date_fin){
   
        $chiffre_affaire_encai = Facture::where([['user_id',$this->id],['reglee',true]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->whereBetween('date_reglement', [$date_deb, $date_fin])->sum('montant_ht');
        return $chiffre_affaire_encai; 
     
    }

    // Chiffre d'affaire stylimmo encaissé compris entre date deb et date fin
        public function  chiffre_affaire_styl($date_deb, $date_fin){


            $compro_encaisse_partage_pas_n = Compromis::where([['user_id',$this->id],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_partage_pas_n = 0;
            if($compro_encaisse_partage_pas_n != null){                
                foreach ($compro_encaisse_partage_pas_n as $compros_encaisse) {
                    if($compros_encaisse->getFactureStylimmo()->a_avoir == false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                        $ca_encaisse_partage_pas_n +=  $compros_encaisse->getFactureStylimmo()->montant_ttc;
                    
                    }
               }
               
           }
        
            // CA encaissé partagé et porte affaire
            $compro_encaisse_porte_n = Compromis::where([['user_id',$this->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_n = 0;

                if($compro_encaisse_porte_n != null){
                    foreach ($compro_encaisse_porte_n as $compros_encaisse) {

                        if($compros_encaisse->getFactureStylimmo()->a_avoir == false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                        }
                    }
                }


            // CA encaissé partagé et ne porte pas affaire
 
            $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',$this->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_pas_n = 0;

                if($compro_encaisse_porte_pas_n != null){
                    foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                        if($compros_encaisse->getFactureStylimmo()->a_avoir == false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                        }
                    }
                }

         
            
            $ca_encaisse_N = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/Tva::coefficient_tva(),2);


        return $ca_encaisse_N ;    
         
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


    public function  date_anniv(){

            // On va determiner la dernière date d'anniv de sa date d'anniversaire
           
            if($this->contrat == null){
                return null;
            }
            $m_d_entree = $this->contrat->date_deb_activite->format('m-d');

            $y_en_cour = date('Y');

            $today = date('Y-m-d');

            // Si aujourdhui > à la date anniv
                if($today > $y_en_cour.'-'.$m_d_entree  ){
                    $date_anniv = $y_en_cour.'-'.$m_d_entree ;
                    
                }else{
                    $date_anniv =  ($y_en_cour-1).'-'.$m_d_entree ;
        
                }

            return $date_anniv; 
     
    }


}
