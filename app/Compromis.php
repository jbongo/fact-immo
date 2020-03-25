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


    // CALCULS DES CHIFFRES D'AFFAIRES

    // Retourne le chiffre d'affaire stylimmo d'un mandataire sur une période
    public static function getCAStylimmo($mandataire_id, $date_deb, $date_fin){

        $CA_partage_pas = 0;
            
        $CA_partage = 0;
            $ca_partage_porte = 0;
            $ca_partage_porte_pas = 0;


        // On determnine le CA des affaires non partagée
        $CA_partage_pas = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',0],['cloture_affaire',1]])->whereBetween('date_vente',[$date_deb, $date_fin])->sum('frais_agence');

        // On détermine le CA des affaires partagées 
        $compros_partage_porte = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',1],['cloture_affaire',1]])->whereBetween('date_vente',[$date_deb, $date_fin])->get();
        $compros_partage_porte_pas = Compromis::where([['agent_id',$mandataire_id],['est_partage_agent',1],['cloture_affaire',1]])->whereBetween('date_vente',[$date_deb, $date_fin])->get();

        foreach ($compros_partage_porte as $cppp) {
            $ca_partage_porte += $cppp->frais_agence * ($cppp->pourcentage_agent / 100 );
        }

        foreach ($compros_partage_porte_pas as $cppp_pas) {
            $ca_partage_porte_pas += $cppp_pas->frais_agence * ( (100 - $cppp_pas->pourcentage_agent) / 100 );
        }

        $CA_partage = $ca_partage_porte + $ca_partage_porte_pas;

        
        $ca_ht = ($CA_partage_pas + $CA_partage)/1.2; 

        // on retourne le chiffre d'affaires hors taxes
        return $ca_ht;
     
       
    }

}
