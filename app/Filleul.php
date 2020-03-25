<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filleul extends Model
{
    //
    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ## Veérifier si un parrain a le droit de toucher une commission de parrainage, 
    public static function droitParrainage($parrain_id, $filleul_id, $compromis_id){
        

        
    
        $parametre = Parametre::first();
        $comm_parrain = unserialize($parametre->comm_parrain) ;

        $parrain = User::where('id',$parrain_id)->first();
        $filleul = User::where('id',$filleul_id)->first();
        $compromis = Compromis::where('id', $compromis_id)->first();

           // ########### Mise en place des conditions de parrainnage ############
            // Vérifier le CA du parrain et du filleul sur les 12 derniers mois précédents la date de vente et qui respectent les critères et vérifier s'il sont à jour dans le reglèmement de leur factures stylimmo 
            // Dans cette partie on détermine le jour exaxt de il y'a 12 mois avant la date de vente
           
        $date_vente = $compromis->date_vente->format('Y-m-d');
        // date_12 est la date exacte 1 ans avant la date de vente
        $date_12 =  strtotime( $date_vente. " -1 year"); 
        $date_12 = date('Y-m-d',$date_12);

        $ca_parrain =  Compromis::getCAStylimmo($parrain_id,$date_12 ,$date_vente);
        $ca_filleul =  Compromis::getCAStylimmo($filleul_id,$date_12 ,$date_vente);

        // on vérifie si le ca depasse le seuil demandé 
       
                                
            // 1 on determine l'ancieneté du filleul
            $date_deb_activ =  strtotime($filleul->contrat->date_deb_activite);                                              
            $today = strtotime (date('Y-m-d'));
            $anciennete_filleul = $today - $date_deb_activ;

            if( $anciennete_filleul <= 365*86400){
                $seuil_filleul = $comm_parrain["seuil_fill_1"];
                $seuil_parrain = $comm_parrain["seuil_parr_1"];
            }
            //si ancienneté est compris entre 1 et 2ans
            elseif($anciennete_filleul > 365*86400 && $anciennete_filleul <= 365*86400*2){
                $seuil_filleul = $comm_parrain["seuil_fill_2"];
                $seuil_parrain = $comm_parrain["seuil_parr_2"];
            }
            // ancienneté sup à 2 ans
            else{
                $seuil_filleul = $comm_parrain["seuil_fill_3"];
                $seuil_parrain = $comm_parrain["seuil_parr_3"];
            }
            $date_12 = strftime("%d/%m/%Y", strtotime($date_12)); 
// dd($date_12);
            // On  n'a les seuils et les ca on peut maintenant faire les comparaisons    
            $respect_condition = false;                            
            if($ca_filleul >= $seuil_filleul && $ca_parrain >= $seuil_parrain ){
                $respect_condition = true;
            }
            $result = ["respect_condition"=>$respect_condition, "ca_filleul"=>$ca_filleul, "ca_parrain"=>$ca_parrain, "date_12" => $date_12, "seuil_filleul"=>$seuil_filleul, "seuil_parrain"=>$seuil_parrain, ];
        
            // dd($result);
            return $result;

    }
}
