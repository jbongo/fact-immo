<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compromis extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_vente','date_mandat','date_signature'];


    public function  user(){
        return $this->belongsTo('App\User');
    }

    public function getPartage(){

        $partage = User::where('id',$this->agent_id)->first();
        return $partage;
    }

    public function getParrainPartage(){

        $partage = User::where('id',$this->parrain_partage_id)->first();
        return $partage;
    }

    public function getFactureStylimmo(){

        $facture = Facture::where([['compromis_id',$this->id],['type','stylimmo']])->first();
        return $facture;
    }
    public function getHonoPorteur(){

        $facture = Facture::where([['compromis_id',$this->id],['user_id',$this->user_id]])->whereIn('type',['honoraire','partage'])->first();
        return $facture;
    }

    public function getHonoPartage(){

        $facture = Facture::where([['compromis_id',$this->id],['user_id',$this->agent_id]])->whereIn('type',['partage'])->first();
        return $facture;
    }

    public function getFactureParrainPorteur(){

        $facture = Facture::where([['compromis_id',$this->id]])->whereIn('type',['parrainage'])->first();
        return $facture;
    }

    public function getFactureParrainPartage(){

        $facture = Facture::where([['compromis_id',$this->id]])->whereIn('type',['parrainage_partage'])->first();
        return $facture;
    }
      

    // CALCULS DES CHIFFRES D'AFFAIRES

    // Retourne le chiffre d'affaire stylimmo d'un mandataire sur une période
    public static function getCAStylimmo($mandataire_id, $date_deb, $date_fin){

    

            $compro_encaisse_partage_pas_n = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_partage_pas_n = 0;
            if($compro_encaisse_partage_pas_n != null){                
                foreach ($compro_encaisse_partage_pas_n as $compros_encaisse) {
                    if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                        $ca_encaisse_partage_pas_n +=  $compros_encaisse->getFactureStylimmo()->montant_ttc;
                    
                    }
               }
               
           }
        
            // CA encaissé partagé et porte affaire
            $compro_encaisse_porte_n = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_n = 0;

                if($compro_encaisse_porte_n != null){
                    foreach ($compro_encaisse_porte_n as $compros_encaisse) {
                        if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                        }
                    }
                }


            // CA encaissé partagé et ne porte pas affaire
 
            $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',$mandataire_id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_pas_n = 0;

                if($compro_encaisse_porte_pas_n != null){
                    foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                        if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                        }
                    }
                }

         
            
            $ca_encaisse_N = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/1.2,2);


return $ca_encaisse_N ;    
       
    }

}
