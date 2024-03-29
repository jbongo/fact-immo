<?php

namespace App\Http\Controllers;

use App\Filleul;
use App\Parametre;
use Illuminate\Http\Request;

class FilleulController extends Controller
{
    /**
     * Calcul de tous pourcentages actuekes des parrains
     *
     * @return \Illuminate\Http\Response
     */
    public function pourcentage_parrain()
    {
        $ids_parrains = Filleul::where('expire',0)->select('parrain_id')->distinct()->get();

        $filleuls = Filleul::where('expire',0)->get();

        // dd($filleuls);
        // dd ($filleuls[1]->user->id);
        $parametre = Parametre::first();

        $comm_parrain = unserialize($parametre->comm_parrain);
// return $filleuls;
        // dd($comm_parrain);
        if($filleuls != null){

            foreach($filleuls as $filleul){
                
                $date_ent =  $filleul->user->contrat->date_entree->format('Y-m-d') >= "2019-01-01" ?  $filleul->user->contrat->date_entree : "2019-01-01";
                $date_entree =  strtotime($date_ent);
                $rang = $filleul->rang <= 3 ? $filleul->rang : 'n';


        
                $today = strtotime (date('Y-m-d'));
                $diff = $today - $date_entree;
              

                // dd(strtotime("2020-01-02") - strtotime('2020-01-01'));
                $trois_ans = 86400*365*3;

                // Après 3ANS d'activités le filleul expire
                if($diff >= $trois_ans){

                   $filleul->expire = 1;
                   $filleul->update();
                   

                //    echo 'update '.$filleul->id;
                }else{
                   
                    // si ancienneté est inférieur à 1 ans
                    if($diff <= 365*86400){
                        $filleul->pourcentage = $comm_parrain["p_1_$rang"];
                    }

                    //si ancienneté est compris entre 1 et 2 ans
                    if($diff > 365*86400 && $diff <= 365*86400*2){
                        $filleul->pourcentage = $comm_parrain["p_2_$rang"];
                    }
                    //si ancienneté est compris entre 2 et 3 ans
                    elseif($diff > 365*86400*2 && $diff <= 365*86400*3){
                        $filleul->pourcentage = $comm_parrain["p_3_$rang"];
                    }
                   
                   $filleul->update();

                }


                
            }
        }


    }


}
