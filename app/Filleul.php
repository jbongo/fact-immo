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
        

        
    

        $parrain = User::where('id',$parrain_id)->first();
        $filleul = User::where('id',$filleul_id)->first();
        $compromis = Compromis::where('id', $compromis_id)->first();

        $comm_parrain = unserialize($filleul->contrat->comm_parrain);


           // ########### Mise en place des conditions de parrainnage ############
            // Vérifier le CA du parrain et du filleul sur les 12 derniers mois précédents la date d'encaissement de la facture STYL et qui respectent les critères et vérifier s'il sont à jour dans le reglèmement de leur factures stylimmo 
            // Dans cette partie on détermine le jour exaxt de il y'a 12 mois avant la date d'encaissement de la facture STYL
           

        $date_encaiss = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d');

        // $date_vente = $compromis->date_vente->format('Y-m-d');
        // date_12 est la date exacte 1 ans avant la date  d'encaissement de la facture STYL
        $date_12 =  strtotime( $date_encaiss. " -1 year"); 
        $date_12 = date('Y-m-d',$date_12);

        $ca_parrain =  Compromis::getCAStylimmo($parrain_id,$date_12 ,$date_encaiss);
        $ca_filleul =  Compromis::getCAStylimmo($filleul_id,$date_12 ,$date_encaiss);

        // on vérifie si le ca depasse le seuil demandé 
                                
            // 1 on determine l'ancieneté du filleul
            // $date_deb_activ =  strtotime($filleul->contrat->date_deb_activite);

            $dt_ent =  $filleul->contrat->date_entree->format('Y-m-d') >= "2019-01-01" ?  $filleul->contrat->date_entree : "2019-01-01";
            $date_entree =  strtotime($dt_ent);  
            
            $today = strtotime (date('Y-m-d'));
            $anciennete_filleul = $today - $date_entree;

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

// on vérifie que le parrain n'a pas dépassé le plafond de la commission de parrainage sur son filleul,  de la date d'anniversaire de sa date d'entrée jusqu'a la date d'encaissement
$m_d_entree = $filleul->contrat->date_entree->format('m-d');
$m_d_entree_fr = $filleul->contrat->date_entree->format('d/m');
$y_encaiss = $compromis->getFactureStylimmo()->date_encaissement->format('Y');

// dd($y_encaiss.'-'.$m_d_entree);
if( $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d') > $y_encaiss.'-'.$m_d_entree  ){
    $date_deb = $y_encaiss.'-'.$m_d_entree ;
    $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d');
    $date_anniv = $m_d_entree_fr.'/'.$y_encaiss;
}else{
    $date_deb =  ($y_encaiss-1).'-'.$m_d_entree ;
    $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'); 
    $date_anniv = $m_d_entree_fr.'/'.($y_encaiss-1);
}
// calcul du de la comm recu par le parrain de date_deb à date_fin 
$ca_comm_parr = Facture::where([['user_id',$parrain_id],['reglee',1]])->whereIn('type',['parrainage','parrainage_partage'])->whereBetween('date_reglement',[$date_deb,$date_fin])->sum('montant_ht');



// On vérifie que le parrain n'a pas démissionné à la date d'encaissement 
$a_demission_parrain = false;

if($parrain->contrat->a_demission == true  ){
    if($parrain->contrat->date_demission <= $compromis->getFactureStylimmo()->date_encaissement ){
        $a_demission_parrain = true;
    }
}

// On vérifie que le filleul n'a pas démissionné à la date d'encaissement 
$a_demission_filleul = false;

if($filleul->contrat->a_demission == true  ){
    if($filleul->contrat->date_demission <= $compromis->getFactureStylimmo()->date_encaissement ){
        $a_demission_filleul = true;
    }
}



            // On  n'a les seuils et les ca on peut maintenant faire les comparaisons    
            $respect_condition = false;                            
            if($ca_filleul >= $seuil_filleul && $ca_parrain >= $seuil_parrain && $ca_comm_parr < $filleul->contrat->seuil_comm && $a_demission_parrain == false &&  $a_demission_filleul == false){
                $respect_condition = true;
            }
            $result = ["respect_condition"=>$respect_condition, "ca_filleul"=>$ca_filleul, "ca_parrain"=>$ca_parrain, "date_12" => $date_12,
                     "seuil_filleul"=>$seuil_filleul, "seuil_parrain"=>$seuil_parrain, "ca_comm_parr"=>$ca_comm_parr, "a_demission_parrain"=>$a_demission_parrain , 
                      "a_demission_filleul"=>$a_demission_filleul, "date_anniv"=>$date_anniv ];
        
            // dd($result);
            return $result;

    }
}
