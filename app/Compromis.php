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






        // // On determnine le CA des affaires non partagée
        // $CA_partage_pas = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',0],['cloture_affaire',0],['archive',false]])->whereBetween('date_vente',[$date_deb, $date_fin])->sum('frais_agence');

        // // On détermine le CA des affaires partagées 
        // $compros_partage_porte = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',1],['cloture_affaire',0],['archive',false]])->whereBetween('date_vente',[$date_deb, $date_fin])->get();
        // $compros_partage_porte_pas = Compromis::where([['agent_id',$mandataire_id],['est_partage_agent',1],['cloture_affaire',0],['archive',false]])->whereBetween('date_vente',[$date_deb, $date_fin])->get();

        // foreach ($compros_partage_porte as $cppp) {
        //     $ca_partage_porte += $cppp->frais_agence * ($cppp->pourcentage_agent / 100 );
        // }

        // foreach ($compros_partage_porte_pas as $cppp_pas) {
        //     $ca_partage_porte_pas += $cppp_pas->frais_agence * ( (100 - $cppp_pas->pourcentage_agent) / 100 );
        // }

        // $CA_partage = $ca_partage_porte + $ca_partage_porte_pas;

        
        // $ca_ht = ($CA_partage_pas + $CA_partage)/1.2; 

        // // on retourne le chiffre d'affaires hors taxes
        // return $ca_ht;
     
       
    }

}
